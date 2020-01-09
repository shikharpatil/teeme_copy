codeigniter-sftp
================

## Overview

SFTP library for CodeIgniter

This is a Library for CodeIgniter that uses sFTP.  I've tried to keep the usage the exact same as the FTP 
library that is included with CodeIgniter.


## Requirements

1.  PHP 5.2
2.  PECL SSH2 Extension
3.  CodeIgniter 2.1.4+

## Installation

Drop this file into the ./application/libraries/ folder in your CodeIgniter installation.

## Usage

This lib has the same methods as the CodeIgniter FTP Class.

## Example (username/password)

```
$this->load->library('sftp');

$config['hostname'] = 'ssh.example.com';
$config['username'] = 'your-username';
$config['password'] = 'your-password';

$this->sftp->connect($config);

$this->sftp->upload('/local/path/to/myfile.html', '/public_html/myfile.html', 'ascii', 0775);

$this->sftp->close();
```