<?php

namespace NewsWeb\Interface;

use NewsWeb\MyPDO;

interface ManagerInterface{
    public function __construct(MyPDO $db);
}