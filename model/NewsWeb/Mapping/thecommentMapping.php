<?php
namespace NewsWeb\Mapping;

class thecommentMapping extends \NewsWeb\Abstract\AbstractMapping{
        private int $idthecomment;
        private int $theuser_idtheuser;
        private string $thecommenttext;
        private string $thecommentdate;
        private int $thecommentactive;

    /**
     * 1
     * @return int
     */
    public function getIdthecomment(): int
    {
        return $this->idthecomment;
    }

    /**
     * 2
     * @return int
     */
    public function getTheuser_idtheuser(): int
    {
        return $this->theuser_idtheuser;
    }

    /**
     * 3
     * @return string
     */
    public function getThecommenttext(): string
    {
        return $this->thecommenttext;
    }

    /**
     * 4
     * @return string
     */
    public function getThecommentdate(): string
    {
        return $this->thecommentdate;
    }

    /**
     * 5
     * @return int
     */
    public function getThecommentactive(): int
    {
        return $this->thecommentactive;
    }

    /**
     * 1
     * @param int $idthecomment
     * @return thecommentMapping
     */
    public function setIdpermission(int $idpermission): thecommentMapping
    {
        $this->idthecomment = $idpermission;
        return $this;
    }

    /**
     * 2
     * @param int $theuser_idtheuser
     * @return thecommentMapping
     */
    public function setTheuser_idtheuser(int $theuser_idtheuser): thecommentMapping
    {
        $this->theuser_idtheuser = $theuser_idtheuser;
        return $this;
    }

    /**
     * 3
     * @param string $thecommenttext
     * @return thecommentMapping
     */
    public function setThecommenttext(string $thecommenttext): thecommentMapping
    {
        if(strlen($thecommenttext)>850) {
            trigger_error("Le texte du commentaire ne doit pas dépasser 45 caractères", E_USER_NOTICE);
            return $this;
        }else{
                $this->thecommenttext = $thecommenttext;
                return $this;
            }
    }

    /**
     * 5
     * @param int $thecommentactive
     * @return thecommentMapping
     */
    public function setThecommentactive(int $thecommentactive): thecommentMapping
    {
        $this->thecommentactive = $thecommentactive;
        return $this;
    }
}
