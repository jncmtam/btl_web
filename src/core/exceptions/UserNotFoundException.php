<?php

class UserNotFoundException extends Exception
{
    protected $message = "User not found.";
    protected $code = 404;
}