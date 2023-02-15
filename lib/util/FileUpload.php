<?php 
    namespace lib\util;

    class FileUpload{
        private ?array $file = null;
        private ?array $allowedTypes = null;
        private ?int $maxSize = null;
        
        public function __construct(array $file, int $maxSize = 0, array $allowedTypes = []){
            $this->file = $file;
            $this->maxSize = $maxSize;
            $this->allowedTypes = $allowedTypes;
        }

        protected function getFilename():string{
            $result = filter_var($this->file['name'],FILTER_SANITIZE_STRING) ?? '';
            return $result;
        }

        public function getUniqFilename():string{
            return uniqid() . '_' . $this->getFilename();
        }

        public function isUploaded():bool{
            $result = isset($this->file['error']);
            return $result && ($this->file['error'] === UPLOAD_ERR_OK);
        }

        public function isSizeOk():bool{
            $result = isset($this->file['size']);
            return $result && ($this->file['size'] <= $this->maxSize);
        }

        public function isTypeOk():bool{
            $result = isset($this->file['tmp_name']);
            if($result){
                $finfo      = finfo_open(FILEINFO_MIME_TYPE);
                $mime_type  = finfo_file($finfo, $this->file['tmp_name']);
                $result     = in_array($mime_type, $this->allowedTypes);
            }
            return $result;
        }

        public function moveTo(string $destination):bool{
            $result = false;
            if($this->isUploaded() && $this->isSizeOk() && $this->isTypeOk()){
                $result = move_uploaded_file($this->file['tmp_name'], $destination);
            }
            return $result;
        }

    }