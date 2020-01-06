<?php

class Attech_Works
{

    public $db, $files_tb, $contents_tb, $imgExt;

    function __construct()
    {
        $this->db = new db();
        $this->db->db_open();

        $this->files_tb = "EY_ATTACH_FILES"; // 파일
        $this->contents_tb = "EY_ATTACH_CONTENTS"; // 컨텐츠

        $this->imgExt = array("jpg", "jpeg", "gif", "png", "bmp");
    }


    /*
     * 파일 추가 메소드
     */
    public function addToFile($p_code, $r_code, $t_code, $path, $file_obj)
    {
        //print_r($file_obj);
        //print_r($p_code, $r_code, $t_code, $path, $file_obj);

        // 확장자
        $ext = strrchr($file_obj["name"], '.');
        $ext = substr($ext, 1);
        $ext = strtolower($ext);

        // 파일 업로드 폴더 정리
        $saveDir = str_replace("/$", "", $path);
        $saveDir .= '/';

        if (!is_dir($saveDir)) {
            // 파일 저장디렉토리가 존재하지 않으면
            @mkdir($saveDir, 0777);
        }

        // 파일 업로드
        if (is_uploaded_file($file_obj["tmp_name"])) {
            $physical_name = uniqid(date("Ymd") . "_") . "." . $ext;
            move_uploaded_file($file_obj["tmp_name"], $saveDir . $physical_name);
            chmod($saveDir . $physical_name, 0777);
        }

        // 파일이 이미지일 경우
        if (in_array($ext, $this->imgExt)) {
            $fileSize = @GetImageSize($saveDir . $physical_name);
            $img_width = $fileSize[0];
            $img_height = $fileSize[1];
        }


        // 파일 등록
        $qry = " INSERT INTO {$this->files_tb} SET";
        $qry .= "  PARENT_CODE = '{$p_code}'";
        $qry .= ", REFERENCE_CODE = '{$r_code}'";
        $qry .= ", TYPE_CODE = '{$t_code}'";
        $qry .= ", FILE_TYPE = 'FILE'";
        $qry .= ", REAL_NAME = '{$file_obj["name"]}'";
        $qry .= ", PHYSICAL_NAME = '{$physical_name}'";
        $qry .= ", EXTENSION_NAME = '{$ext}'";
        $qry .= ", FILE_ROUTE = '{$path}'";
        $qry .= ", FILE_SIZE = '{$file_obj["size"]}'";
        $qry .= ", FILE_WIDTH = '{$img_width}'";
        $qry .= ", FILE_HEIGHT = '{$img_height}'";
        $qry .= ", REG_DATE = now()";

        $this->db->exec_sql($qry);

    }


    /*
     * 파일 정보 가져오기
     */
    public function getFile($p_code, $r_code, $t_code)
    {
        $qry = " SELECT * FROM {$this->files_tb} ";
        $qry .= " WHERE PARENT_CODE = '{$p_code}' ";
        $qry .= " AND REFERENCE_CODE = '{$r_code}' ";
        $qry .= " AND TYPE_CODE = '{$t_code}' ";

        $res = $this->db->exec_sql($qry);
        $row = $this->db->sql_fetch_array($res);

        return $row;
    }


    /*
     * 파일 정보 가져오기
     */
    public function delFileTable($p_code, $r_code, $t_code)
    {
        $qry = " DELETE FROM {$this->files_tb} ";
        $qry .= " WHERE PARENT_CODE = '{$p_code}' ";
        $qry .= " AND REFERENCE_CODE = '{$r_code}' ";

        if ($t_code != "") {
            $qry .= " AND TYPE_CODE = '{$t_code}' ";
        }

        @$this->db->exec_sql($qry);
    }


    /*
     * 파일 삭제 하기
     */
    public function delFile($p_code, $r_code, $t_code, $path)
    {
        $img_obj = $this->getFile($p_code, $r_code, $t_code);

        if ($img_obj["IDX"] != "") {

            $this->delFileTable($p_code, $r_code, $t_code);

            // 파일 폴더 정리
            $saveDir = str_replace("/$", "", $path);
            $saveDir .= '/';

            @unlink($saveDir."/".$img_obj["PHYSICAL_NAME"]) ;

        }
    }






    function __destruct()
    {
        // TODO: Implement __destruct() method.
    }


}