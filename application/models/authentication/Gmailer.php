<?php /*Copyrights © 2008-2009 B3 Technologies Pty Ltd. All rights reserved.*/ ?><?php

#Copyright 2006 Svetlozar Petrov

#All Rights Reserved

#svetlozar@svetlozar.net

#http://svetlozar.net



#Script to import the names and emails from gmail contact list

class GMailer extends CI_Model

{

    var $location = "";

    var $cookiearr = array();



    #Globals Section, $location and $cookiearr should be used in any script that uses

    #getAddressbook function

    #function getAddressbook, accepts as arguments $login (the username) and $password

    #returns array of: array of the names and array of the emails if login successful

    #otherwise returns 1 if login is invalid and 2 if username or password was not specified

   

    function getAddressbook($login, $password)

    {

         #the globals will be updated/used in the read_header function

         global $location;

         global $cookiearr;

         global $ch;



        #check if username and password was given:

        if ((isset($login) && trim($login)=="") || (isset($password) && trim($password)==""))

        {

              return false;

        }

        

        #initialize the curl session

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,"http://mail.google.com/mail/");

        curl_setopt($ch, CURLOPT_REFERER, "");

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

         curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        //curl_setopt($ch, CURLOPT_HEADERFUNCTION, 'read_header');

        curl_setopt($ch, CURLOPT_HEADERFUNCTION, array($this->baseFunction, 'read_header'));  

        

        #get the html from gmail.com

        $html = curl_exec($ch);

        $matches = array();

        $actionarr = array();

        

        $action = "https://www.google.com/accounts/ServiceLoginAuth";

    

        #parse the login form:

        #parse all the hidden elements of the form

        preg_match_all('/<input type\="hidden" name\="([^"]+)".*?value\="([^"]*)"[^>]*>/si', $html, $matches);

        $values = $matches[2];

        $params = "";

        

        $i=0;

        foreach ($matches[1] as $name)

        {

          $params .= "$name=" . urlencode($values[$i]) . "&";

          ++$i;

        }

        

        $login = urlencode($login);

        $password = urlencode($password);

        

		curl_setopt($ch, CURLOPT_URL,$action);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

		curl_setopt($ch, CURLOPT_POST, 1);

		curl_setopt($ch, CURLOPT_POSTFIELDS, $params ."Email=$login&Passwd=$password&PersistentCookie=");

		curl_setopt($ch, CURLOPT_COOKIESESSION, true);

		curl_setopt($ch, CURLOPT_HEADER, true);

		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);

        $html = curl_exec($ch);

    

        #test if login was successful:

        if (preg_match('/url=([^"]*)/', $html, $actionarr)!=0)

        {   

          //  $location = $actionarr[1];

          //  return $location = urldecode($location);  

			return true;

    

        }

        else

        {			

            return false;

        } 

     

    }   

}

?>

