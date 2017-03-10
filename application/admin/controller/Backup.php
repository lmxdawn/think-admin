<?php
// +----------------------------------------------------------------------
// | ThinkPHP 5 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 .
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 黎明晓 <lmxdawn@gmail.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;



/**
 * Class Auth 数据
 * @package app\index\controller
 */
class Backup extends Base {


    public $backup_path = ''; //备份文件夹相对路径
    public $backup_name = ''; //当前备份文件夹名
    public $offset = '500'; //每次取数据条数
    public $dump_sql = '';

    public function _initialize()
    {
        parent::_initialize();
        $this->backup_path = 'data/backup/';
        $this->_database_mod = db();
    }

    /**
     * 数据库备份
     */
    public function index()
    {

        if ($this->request->isPost() || isset($_GET['dosubmit'])) {

            //print_r($_REQUEST);exit();
            if (isset($_GET['type']) && $_GET['type'] == 'url') {

                $sizelimit = isset($_GET['sizelimit']) && abs(intval($_GET['sizelimit'])) ? abs(intval
                ($_GET['sizelimit'])) : $this->error('请输入每个分卷文件大小');

                $this->backup_name = isset($_GET['backup_name']) && trim($_GET['backup_name']) ?
                    trim($_GET['backup_name']) : $this->error('请输入备份名称');

                $vol = $this->_get_vol();
                $vol++;
            } else {
                $sizelimit = isset($_POST['sizelimit']) && abs(intval($_POST['sizelimit'])) ?
                    abs(intval($_POST['sizelimit'])) : $this->error('请输入每个分卷文件大小');


                $this->backup_name = isset($_POST['backup_name']) && trim($_POST['backup_name']) ?
                    trim($_POST['backup_name']) : $this->error('请输入备份名称');


                $backup_tables = isset($_POST['backup_tables']) && $_POST['backup_tables'] ? $_POST['backup_tables'] : $this->error('请选择备份数据表');


                if (!is_dir(ROOT_PATH . $this->backup_path)){
                    mkdir(ROOT_PATH . $this->backup_path);
                }

                if (is_dir(ROOT_PATH . $this->backup_path . $this->backup_name)) {
                    $this->error('备份名称已经存在');
                }else{
                    mkdir(ROOT_PATH . $this->backup_path . $this->backup_name);
                }

                if (!is_file(ROOT_PATH . $this->backup_path . $this->backup_name .
                    '/tbl_queue.log')) {
                    //写入队列
                    $this->_put_tbl_queue($backup_tables);
                }
                $vol = 1;
            }
            $tables = $this->_dump_queue($vol, $sizelimit * 1024);

            if ($tables === false) {
                $this->error('加载队列文件错误');
            }

            $this->_deal_result($tables, $vol, $sizelimit);
            exit();

        }else{

            //dump(ROOT_PATH . $this->backup_path);exit;
            $result =   db()->query("show tables");
            $tables   =   array();
            foreach ($result as $key => $val) {
                $tables[$key] = current($val);
            }
            return $this->view->fetch('index',[
                'title' => '数据库备份',
                'sizelimit' =>  10*1024*1024 / 1024,
                'backup_name'   =>  $this->_make_backup_name(),
                'tables'    =>  $tables,
            ]);
        }

    }


    /**
     * 数据恢复
     */
    public function restore()
    {
        //dump($this->_get_backups());exit;
        return $this->view->fetch('restore',[
            'title' => '数据库还原',
            'backups' =>  $this->_get_backups(),
            'table_list'   =>  true,
        ]);
    }

    /**
     * 导入备份
     */
    public function import()
    {
        $backup = $this->request->param('backup');

        $backup_name = isset($backup) && trim($backup) ? trim($backup) :
            $this->error('请选择备份名称');
        $vol = empty($_GET['vol']) ? 1 : intval($_GET['vol']);
        $this->backup_name = $backup_name;
        //获得所有分卷
        $backups = $this->_get_vols($this->backup_name);
        $backup = isset($backups[$vol]) && $backups[$vol] ? $backups[$vol] : $this->error('无此文件！');
        //开始导入卷
        if ($this->_import_vol($backup['file']))
        {
            if ($vol < count($backups))
            {
                $vol++;
                $link = Url("Backup/import",array("vol"=>$vol,"backup"=>urlencode($this->backup_name)));
                $this->success(sprintf('导入成功！', $vol - 1), $link);
            } else
            {
                $this->success('导入成功！', Url("Backup/restore"));
            }
        }
    }

    private function _import_vol($sql_file_name)
    {
        $sql_file = ROOT_PATH . $this->backup_path . $this->backup_name . '/' . $sql_file_name;
        $sql_str = file($sql_file);
        $sql_str = preg_replace("/^--.+\n/",'', $sql_str);
        $sql_str = str_replace("\r", '', implode('', $sql_str));
        $ret = explode(";\n", $sql_str);
        $ret_count = count($ret);
        for ($i = 0; $i < $ret_count; $i++)
        {
            $ret[$i] = trim($ret[$i], " \r\n;"); //剔除多余信息
            if (!empty($ret[$i]))
            {
                $this->_database_mod->execute($ret[$i]);
            }
        }
        return true;
    }

    /**
     * 删除备份
     */
    public function del_backup()
    {
        $backup = $this->request->param('backup');

        if ((!isset($backup) || empty($backup)) && (!isset($backup) ||
                empty($backup)))
        {
            $this->error('非法参数');
        }
        $dir =  ROOT_PATH . $this->backup_path . $backup.'/';
        $dh=opendir($dir);
        while ($file=readdir($dh)) {
            if($file!="." && $file!="..") {
                $fullpath=$dir."/".$file;
                if(!is_dir($fullpath)) {
                    unlink($fullpath);
                } else {
                    deldir($fullpath);
                }
            }
        }

        closedir($dh);
        //删除当前文件夹：
        if(rmdir($dir)) {
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！');
        }


    }

    /**
     * 下载备份文件
     */
    public function download()
    {
        $backup = $this->request->param('backup');
        $backup_name = isset($backup) && trim($backup) ? trim($backup) : $this->error('请选择备份名称！');
        $file = $this->request->param('file');
        $file = isset($file) && trim($file) ? trim($file) : $this->error('请选择备份文件！');
        $sql_file = ROOT_PATH . $this->backup_path . $backup_name . '/' . $file;
        if (file_exists($sql_file))
        {
            header('Content-type: application/unknown');
            header('Content-Disposition: attachment; filename="' . $file . '"');
            header("Content-Length: " . filesize($sql_file) . "; ");
            readfile($sql_file);
        } else
        {
            $this->error('文件不存在！');
        }
    }

    /**
     * 获得备份文件夹下的sql文件
     */
    private function _get_vols($backup_name)
    {
        $vols = array(); //所有的卷
        $bytes = 0;
        $vol_path = ROOT_PATH . $this->backup_path . $backup_name . '/';
        if (is_dir($vol_path))
        {
            if ($handle = opendir($vol_path))
            {
                $vol = array();
                while (($file = readdir($handle)) !== false)
                {
                    $file_info = pathinfo($vol_path . $file);
                    if ($file_info['extension'] == 'sql')
                    {
                        $vol = $this->_get_head($vol_path . $file);
                        $vol['file'] = $file;
                        $bytes += filesize($vol_path . $file);
                        $vol['size'] = ceil(10 * filesize($vol_path . $file) / 1024) / 10;
                        $vol['total_size'] = ceil(10 * $bytes / 1024) / 10;
                        $vols[$vol['vol']] = $vol;
                    }
                }
            }
        }
        ksort($vols);
        return $vols;
    }

    /**
     * 获得备份列表
     */
    private function _get_backups()
    {
        $backups = array(); //所有的备份
        if (is_dir(ROOT_PATH . $this->backup_path))
        {
            if ($handle = opendir(ROOT_PATH . $this->backup_path))
            {
                while (($file = readdir($handle)) !== false)
                {
                    if ($file{0} != '.' && filetype(ROOT_PATH . $this->backup_path . $file) == 'dir')
                    {
                        $backup['name'] = $file;
                        $backup['date'] = filemtime(ROOT_PATH . $this->backup_path . $file);// - date('Z');
                        $backup['date_str'] = date('Y-m-d H:i:s', $backup['date']);
                        $backup['vols'] = $this->_get_vols($file);
                        $end_vol = end($backup['vols']);
                        $backup['total_size'] =round($this->_get_dir_size(ROOT_PATH . $this->backup_path . $file)/1024,2);
                        $backups[] = $backup;
                    }
                }
            }
        }
        ksort($backups);
        return $backups;
    }

    private function _deal_result($tables, $vol, $sizelimit)
    {
        $this->_sava_sql($vol);
        if (empty($tables))
        {
            //备份完毕
            $this->_drop_tbl_queue();
            $vol != 1 && $this->_drop_vol(); //只有一卷时不需删除
            $this->success('备份成功！',Url("Backup/restore"));
        } else
        {
            //开始下一卷
            $this->_set_vol($vol); //设置分卷记录
            $link= Url("Backup/index",array("dosubmit"=>1,"type"=>"url","backup_name"=>$this->backup_name,"sizelimit"=>$sizelimit));
            $this->success(sprintf('备份写入成功！', $vol), $link);
        }
    }

    private function _dump_queue($vol, $sizelimit)
    {
        $queue_tables = $this->_get_tbl_queue();
        if (!$queue_tables)
        {
            return false;
        }

        $this->dump_sql = $this->_make_head($vol);

        foreach ($queue_tables as $table => $pos)
        {
            //获取表结构
            if ($pos == '-1')
            {
                $table_df = $this->_get_table_df($table);
                if (strlen($this->dump_sql) + strlen($table_df) > $sizelimit)
                {
                    break;
                } else
                {
                    $this->dump_sql .= $table_df;
                    $pos = 0;
                }
            }
            //获取表数据
            $post_pos = $this->_get_table_data($table, $pos, $sizelimit);
            if ($post_pos == -1)
            {
                unset($queue_tables[$table]); //此表已经完全导出
            } else
            {
                //此表未完成，放到下一个分卷
                $queue_tables[$table] = $post_pos;
                break;
            }
        }
        $this->_put_tbl_queue($queue_tables);
        return $queue_tables;
    }

    /**
     * 获取数据表结构语句
     *
     * @param string $table 表名
     */
    private function _get_table_df($table)
    {
        $table_df = "DROP TABLE IF EXISTS `$table`;\n";
        $tmp_sql = $this->_database_mod->query("SHOW CREATE TABLE `$table` ");
//        var_dump($tmp_sql);exit();
        $tmp_sql = $tmp_sql['0']['Create Table'];
        $tmp_sql = substr($tmp_sql, 0, strrpos($tmp_sql, ")") + 1); //去除行尾定义。
        $tmp_sql = str_replace("\n", "\r\n", $tmp_sql);
        $table_df .= $tmp_sql . " COLLATE='utf8_general_ci' ENGINE=MyISAM;\r\n";
        return $table_df;
    }

    /**
     * 获取数据表数据
     */
    private function _get_table_data($table, $pos, $sizelimit)
    {
        $post_pos = $pos;
        $total = $this->_database_mod->query("SELECT COUNT(*) as count FROM $table"); //数据总数
        $total = $total[0]['count'];

        if ($total == 0 || $pos >= $total)
        {
            return - 1;
        }
        $cycle_time = ceil(($total - $pos) / $this->offset); //每次取offset条数。获得需要取的次数
        for ($i = 0; $i < $cycle_time; $i++)
        {
            $data = $this->_database_mod->query("SELECT * FROM $table LIMIT " . ($this->
                    offset * $i + $pos) . ', ' . $this->offset);
            $data_count = count($data);
            $fields = array_keys($data[0]);
            $start_sql = "INSERT INTO $table ( `" . implode("`, `", $fields) . "` ) VALUES ";
            //循环将数据写入
            for ($j = 0; $j < $data_count; $j++)
            {
                $record = array_map(array($this, '_dump_escape_string'), $data[$j]); //过滤非法字符

                $tmp_dump_sql = $start_sql . " (" . $this->_implode_insert_values($record) . ");\r\n";
                if (strlen($this->dump_sql) + strlen($tmp_dump_sql) > $sizelimit - 32)
                {
                    return $post_pos;
                } else
                {
                    $this->dump_sql .= $tmp_dump_sql;
                    $post_pos++;
                }
            }
        }
        return - 1;
    }

    private function _dump_escape_string($str)
    {
        return addslashes($str);
        //return $this->_database_mod->escape_string($str);
    }

    /**
     * 备份文件头部声明信息
     */
    private function _make_head($vol)
    {
        $date = date('Y-m-d H:i:s', time());
        $head = "-- lmxdawn SQL Dump Program\r\n" . "-- \r\n" . "-- DATE : " . $date . "\r\n" .
            "-- Vol : " . $vol . "\r\n";
        return $head;
    }

    /**
     * 获得头文件信息
     */
    private function _get_head($path)
    {
        $fp = fopen($path, 'rb');
        $str = fread($fp, 90);
        fclose($fp);
        $arr = explode("\n", $str);
        foreach ($arr as $val)
        {
            $pos = strpos($val, ':');
            if ($pos > 0)
            {
                $type = trim(substr($val, 0, $pos), "-\n\r\t ");
                $value = trim(substr($val, $pos + 1), "/\n\r\t ");
                if ($type == 'DATE')
                {
                    $sql_info['date'] = $value;
                } elseif ($type == 'Vol')
                {
                    $sql_info['vol'] = $value;
                }
            }
        }
        return $sql_info;
    }

    /**
     * 生成备份文件夹名称
     */
    private function _make_backup_name()
    {
        $backup_path = ROOT_PATH . '/data/backup/';
        $today = date('Ymd_', time());
        $today_backup = array(); //保存今天已经备份过的
        if (is_dir($backup_path))
        {
            if ($handle = opendir($backup_path))
            {
                while (($file = readdir($handle)) !== false)
                {
                    if ($file{0} != '.' && filetype($backup_path . $file) == 'dir')
                    {
                        if (strpos($file, $today) === 0)
                        {
                            $no = intval(str_replace($today, '', $file)); //当天的编号
                            if ($no)
                            {
                                $today_backup[] = $no;
                            }
                        }
                    }
                }
            }
        }
        if ($today_backup)
        {
            $today .= max($today_backup) + 1;
        } else
        {
            $today .= '1';
        }
        return $today;
    }

    /**
     * 需要备份的数据表写入队列
     */
    private function _put_tbl_queue($tables)
    {
        return file_put_contents(ROOT_PATH . $this->backup_path . $this->backup_name .
            '/tbl_queue.log', "<?php return " . var_export($tables, true) . ";\n?>");
    }

    /**
     * 获取需要处理的数据表队列
     */
    private function _get_tbl_queue()
    {
        $tbl_queue_file = ROOT_PATH . $this->backup_path . $this->backup_name .
            '/tbl_queue.log';
        if (!is_file($tbl_queue_file))
        {
            return false;
        } else
        {
            return include ($tbl_queue_file);
        }
    }

    /**
     * 删除队列文件
     */
    private function _drop_tbl_queue()
    {
        $tbl_queue_file = ROOT_PATH . $this->backup_path . $this->backup_name .
            '/tbl_queue.log';
        return @unlink($tbl_queue_file);
    }

    /**
     * 写入分卷记录
     */
    private function _set_vol($vol)
    {
        $log_file = ROOT_PATH . $this->backup_path . $this->backup_name . '/vol.log';
        return file_put_contents($log_file, $vol);
    }

    /**
     * 获取上一次操作分卷记录
     */
    private function _get_vol()
    {
        $log_file = ROOT_PATH . $this->backup_path . $this->backup_name . '/vol.log';
        if (!is_file($log_file))
        {
            return 0;
        }
        $content = file_get_contents($log_file);
        return is_numeric($content) ? intval($content) : false;
    }

    /**
     * 删除分卷记录文件
     */
    private function _drop_vol()
    {
        $log_file = ROOT_PATH . $this->backup_path . $this->backup_name . '/vol.log';
        return @unlink($log_file);
    }

    /**
     * 保存导出的sql
     */
    private function _sava_sql($vol)
    {
        return file_put_contents(ROOT_PATH . $this->backup_path . $this->backup_name .
            '/' . $this->backup_name . '_' . $vol . '.sql', $this->dump_sql);
    }

    /**
     * 对 MYSQL INSERT INTO 语句的values部分内容进行字符串连接
     *
     * @param array $values
     * @return string
     */
    private function _implode_insert_values($values)
    {
        $str = '';
        $values = array_values($values);
        foreach ($values as $k => $v)
        {
            $v = ($v === null || $v == '') ? 'null' : "'" . $v . "'";
            $str = ($k == 0) ? $str . $v : $str . ',' . $v;
        }
        return $str;
    }

    /**
     * 将G M K转换为字节
     *
     * @param string $val
     * @return int
     */
    private function _return_bytes($val)
    {
        $val = trim($val);
        $last = strtolower($val[strlen($val) - 1]);
        switch ($last)
        {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        return $val;
    }
    function _get_dir_size($dir)
    {
        $handle = opendir($dir);
        $sizeResult=0;
        while (false !== ($FolderOrFile = readdir($handle)))
        {
            if ($FolderOrFile != "." && $FolderOrFile != "..")
            {
                if (is_dir("$dir/$FolderOrFile"))
                {
                    $sizeResult += getDirSize("$dir/$FolderOrFile");
                } else
                {
                    $sizeResult += filesize("$dir/$FolderOrFile");
                }
            }
        }
        closedir($handle);
        return $sizeResult;
    }

}
