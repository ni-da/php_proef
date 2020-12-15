<?php
class User
{
    public $user_id;
    public $user_name;
    public $user_firstname;
    public $user_email;
    public $signed_agreement;
    public $user_language;
    public $user_level;
    public $user_force_password;
    public $user_mobile;
    public $user_tel;
    public $profile_img;

    public function isAgreementSigned()
    {
        return $this->signed_agreement;
    }
    public function isPasswordChangeNeeded()
    {
        return $this->user_force_password;
    }
    public function getEUL($checksum, $user_access_token)
    {
        return json_decode(getUserEul($checksum, $user_access_token), TRUE)['result']['eul_content'];
    }
}
