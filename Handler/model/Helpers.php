<?php
    
    class Helpers{

        public function sendEmailNotif_uft8($to, $from_user, $from_email, $subject = '(No subject)', $message = '', $cc=""){
            $from_user = "=?UTF-8?B?".base64_encode($from_user)."?=";
            $subject = "=?UTF-8?B?".base64_encode($subject)."?=";

            $headers = "From: $from_user <$from_email>\r\n".
                       "MIME-Version: 1.0" . "\r\n" .
                       "Content-type: text/html; charset=UTF-8" . "\r\n";

            if ($cc != ""){
                $headers .= "CC: ". $cc ." \r\n";
            }

            return mail($to, $subject, $message, $headers);
        }

        public function sanitizeInput($input){
            $inputTemp = "";

            $inputTemp = htmlspecialchars($input, ENT_QUOTES);
            $inputTemp = filter_var($inputTemp, FILTER_SANITIZE_STRING);
            $inputTemp = $this->conn->real_escape_string($inputTemp);

            return $inputTemp;
        }

        public function sanitizePassword($input){
            $inputTemp = "";

            $inputTemp = htmlspecialchars($input, ENT_QUOTES);
            $inputTemp = filter_var($inputTemp, FILTER_SANITIZE_STRING);
            $inputTemp = $this->conn->real_escape_string($inputTemp);

            $inputTemp = md5($inputTemp);

            return $inputTemp;
        }


        public function send_download($file, $origFileName) {
            $basename = basename($origFileName);
            $length   = sprintf("%u", filesize($file));

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $basename . '"');
            header('Content-Transfer-Encoding: binary');
            header('Connection: Keep-Alive');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . $length);

            set_time_limit(0);
            readfile($file);
        }


        public function validExtension($ext){
            $validExtensions = array("xls", "xlt", "xlm", "xlsx", "xlsm", "xltx",
                                        "xltm", "xlsb", "xla", "xlam", "xll", "xlw",
                                        "ppt", "pot", "pps", "pptx", "pptm", "potx",
                                        "potm", "ppam", "ppsx", "ppsm", "sldx", "sldm",
                                        "doc", "docm", "docx", "dot", "dotm", "dotx",
                                        "msg", "pdf");

            if (in_array(strtolower($ext)."" , $validExtensions)){
                return true;
            }
            return false;
        }

        public function toValidMySQLDate($date){
            $dateTmp = strtotime($date);
            $date = date("Y-m-d", $dateTmp);

            return $date;
        }

        public function toValidMySQLDateWithHrsMins($date){
            $dateTmp = strtotime($date);
            $date = date("Y-m-d H:i:s", $dateTmp);

            return $date;
        }


        public function getMinuteDiff($firstDate, $secondDate){
            $firstDate = $this->toValidMySQLDateWithHrsMins($firstDate);
            $secondDate = $this->toValidMySQLDateWithHrsMins($secondDate);

            // return $firstDate ." - ". $secondDate

            $query = "SELECT TIMESTAMPDIFF(MINUTE, '". $firstDate ."', '". $secondDate ."' ) as statusTimeS";

            //echo $query;
            $result = $this->conn->query($query);

            if (is_object($result) && !empty($result->num_rows)) {

                while ($row = $result->fetch_assoc()) {
                    return array("timeSpan" => $row['statusTimeS']);
                }
            }
            return array();
        }

        public function getValidExtensionForImg(){
            $validExtensions = array("bmp", "dds", "gif", "jpg", "jpeg", "png",
									"pspimage", "tga", "thm", "tif", "tiff",
									"yuv", "jif", "jfif", "jp2", "jpx", "j2k",
									"j2c", "fpx", "pcd");

            return $validExtensions;
        }

        public function getValidExtensionForDocs(){
            $validExtensions = array("xls", "xlt", "xlm", "xlsx", "xlsm", "xltx",
                                                "xltm", "xlsb", "xla", "xlam", "xll", "xlw",
                                                "ppt", "pot", "pps", "pptx", "pptm", "potx",
                                                "potm", "ppam", "ppsx", "ppsm", "sldx", "sldm",
                                                "doc", "docm", "docx", "dot", "dotm", "dotx",
                                                "msg", "pdf");

            return $validExtensions;
        }

        public function getInvalidExtensionsForAnyFile(){
            $invalidExtensions = array(
                                "php", "html","htm","py", "js", "css", "mp3", "mp4",
                                "avi", "flv", "wmv", "mov", "asf", "swf", "avchd",
                                "webm", "mpg", "mp2", "mpeg", "mpv", "mpe", "ogg",
                                "m4p", "m4v", "mpa", "aac", "oga", "tar", "rar",
                                "zip", "a", "asm", "asp", "awk", "bat", "btm", "c",
                                "class", "cmd", "cpp", "csv", "cur", "cxx", "db", "def",
                                "des", "dlg", "dll", "don", "dpj", "dtd", "dump", "dxp",
                                "eng", "exe", "flt", "fmt", "font", "fp", "ft",
                                "h", "hdb", "hdl", "hid", "hpp", "hrc", "hxx", "ico",
                                "idl", "ih", "ilb", "inc", "inf", "ini", "inl", "ins",
                                "java", "jar", "jnl", "jsp", "kdelnk", "l", "lgt", "lib",
                                "lin", "ll", "ln3", "lng", "lnk", "lnx", "log", "lst",
                                "mac", "macos", "map", "mk", "mod", "nt2", "o", "obj",
                                "par", "pfa", "pfb", "pl", "plc", "pld", "plf", "pm",
                                "pmk", "pre", "prj", "prt", "ps", "ptr", "r", "rc", "rdb",
                                "res", "s", "sbl", "scp", "sda", "sdb", "sdc", "sdd", "sdg",
                                "sdm", "sds", "sdv", "sdw", "sdi", "seg", "sdi", "seg", "set",
                                "sgl", "sh", "sid", "smf", "sms", "so", "sob", "soh", "soc", "sod",
                                "soe", "sog", "soh", "src", "srs", "ssleay", "static", "tab", "tfm",
                                "thm", "tpt", "tsc", "ttf", "txt", "unx", "urd", "url", "vms", "vor",
                                "w32", "wav", "wmf", "xml", "xpm", "xrb", "y", "yxx", "zip", "gitignore",
                                "git", "conf", "conv", "cnf", "key", "crt"
                            );

            return $invalidExtensions;
        }

        public function getFileUploadErrorCode($code){
            $phpFileUploadErrors = array(
                                        0 => 'There is no error, the file uploaded with success',
                                        1 => 'The uploaded file exceeds the allowed maximum file size',
                                        2 => 'The uploaded file exceeds the maximum file size directive that was specified in the HTML form',
                                        3 => 'The uploaded file was only partially uploaded',
                                        4 => 'No file was uploaded',
                                        6 => 'Missing a temporary folder',
                                        7 => 'Failed to write file to disk.',
                                        8 => 'A system stopped the file upload.',
                                    );

            return $phpFileUploadErrors[$code];
        }

        public function uploadSingleFile($classImgName, $FILES){ 

            $results = array("done" => "FALSE",
                            "msg" => "Error uploading",
                            "fileName" => "",
                            "newFileName" => "",
                            "uploadedFileType" => "0");

            $image_targetFolder = $this->__CON_UPLOAD_IMGS_PATH; 
            $docs_targetFolder = $this->__CON_UPLOAD_DOCS_PATH;
            $validFileSize = $this->__CON_UPLOAD_VALID_FILESIZE; 

            
            $img_validExtensions = $this->getValidExtensionForImg();
            $docs_validExtensions = $this->getValidExtensionForDocs();
            $in_validExtensions = $this->getInvalidExtensionsForAnyFile();

            $fileName = $FILES[$classImgName]['name'];
            $fileTmpName = $FILES[$classImgName]['tmp_name'];
            $ext = explode(".", basename($fileName));
            $fileExtension = strtolower(end($ext));
            $fileSize = $FILES[$classImgName]['size'];

            $newFileName = strtoupper(md5(uniqid())) . "." . $ext[count($ext) - 1];

            if ($fileSize <= $validFileSize){

                if (! in_array($fileExtension ."", $in_validExtensions)){
                    if (!empty($FILES[$classImgName]['error'])){

                        $results = array("done" => "FALSE",
                                        "msg" => "Error uploading ". $fileName ." -> ". $this->getFileUploadErrorCode($FILES[$classImgName]['error']),
                                        "fileName" => "",
                                        "newFileName" => "");
                    }else{

                        if(!empty($fileTmpName) && is_uploaded_file($fileTmpName)){

                            $uploadedFileType = "1"; // image

                            if (in_array($fileExtension ."", $img_validExtensions)){

                                $uploadedFileType = "1"; // image
                                $target_path = $image_targetFolder . $newFileName;

                            }else if (in_array($fileExtension ."", $docs_validExtensions)) {

                                $uploadedFileType = "2"; // docs, emails -> means downloadable
                                $target_path = $docs_targetFolder . $newFileName;

                            }else{
                                $target_path = "";
                            }

                            if ($target_path != ""){

                                if (move_uploaded_file($fileTmpName, $target_path) === true){
                                    $results = array("done" => "TRUE",
                                                    "msg" => "Uploaded",
                                                    "fileName" => $fileName,
                                                    "newFileName" => $newFileName,
                                                    "uploadedFileType" => $uploadedFileType);
                                }
                            }else{

                                $results = array("done" => "FALSE",
                                                "msg" => "Invalid file extension: " . $fileExtension,
                                                "fileName" => "",
                                                "newFileName" => "",
                                                "uploadedFileType" => "0");

                            }

                        }else{

                            $results = array("done" => "FALSE",
                                        "msg" => "Error uploading ". $fileName ." -> ". $this->getFileUploadErrorCode($FILES[$classImgName]['error']),
                                        "fileName" => "",
                                        "newFileName" => "",
                                        "uploadedFileType" => "0");
                        }
                    }
                }else{

                    $results = array("done" => "FALSE",
                            "msg" => "Invalid file extension : " . $fileExtension,
                            "fileName" => "",
                            "newFileName" => "",
                            "uploadedFileType" => "0");

                }
            }else{

                $results = array("done" => "FALSE",
                        "msg" => "Invalid file size",
                        "fileName" => "",
                        "newFileName" => "",
                        "uploadedFileType" => "0");

            }

            return $results;
        }

        public function getNewTicket(){
            $today = date("ymdHis");
            return $this->__CON_TICKET_NUM_SITE.$today;
        }
    }

?>
