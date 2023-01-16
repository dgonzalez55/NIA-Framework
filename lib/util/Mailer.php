<?php 
    namespace lib\util;
    //External Libraries
    use PHPMailer\PHPMailer\PHPMailer;

    class Mailer extends PHPMailer{

        //Apliquem Singleton Pattern
        private static ?self $instance = null;
        
        private function __construct(){
            //Cridem al constructor de la classe pare
            parent::__construct();
            //Configurem el servidor de correu
            $this->IsSMTP();
            $this->SMTPDebug    = MAIL_DEBUG;
            $this->SMTPAuth     = MAIL_AUTH;
            $this->SMTPSecure   = MAIL_SECURE;
            $this->Host         = MAIL_HOST;
            $this->Port         = MAIL_PORT;
            $this->Username     = MAIL_USER;
            $this->Password     = MAIL_PASS;
            $this->CharSet      = MAIL_CHARSET;
        }

        public function sendMail(string $email,string $subject,string $body,bool $isHTML){
            $this->SetFrom(MAIL_FROM, MAIL_FROM_NAME);
            $this->Subject = $subject;
            $isHTML ? $this->setHTMLMail($body) : $this->setPlainTextMail($body);
            $this->AddAddress($email);
            return $this->Send();
        }

        private function setHTMLMail(string $body){
            $this->IsHTML(true);
            $this->MsgHTML($body,APP_BASE_PATH."public");
        }

        private function setPlainTextMail(string $body){
            $this->IsHTML(false);
            $this->Body = $body;
        }

        public static function getInstance():self{
            if(static::$instance === null){
                static::$instance = new static();
            }
            return static::$instance;
        }

        private function __clone(){}
    }