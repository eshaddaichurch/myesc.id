<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Secret diambil dari environment variable di server, tidak ditulis di kode.
$config['recaptcha_secret'] = getenv('RECAPTCHA_SECRET_V3') ?: '';