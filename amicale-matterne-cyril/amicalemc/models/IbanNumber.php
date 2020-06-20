<?php
    namespace app\models;
    

    use PHP_IBAN\IBAN;
    use \SoapClient;

    class IbanNumber extends IBAN{

        public function getIban(){
            return $this->iban;
        }
    }