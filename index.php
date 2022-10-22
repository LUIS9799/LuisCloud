<?php

//#CodedbyLuis
$anti_ddos_protection_enable = false;

$anti_ddos_debug = true;

$test_not_rated_ua = true;

$anti_ddos_protection_enable_ext_file = 'anti_ddos_protection_fire.dat';
if ($anti_ddos_protection_enable === false && isset($anti_ddos_protection_enable_ext_file) && file_exists($anti_ddos_protection_enable_ext_file)) {
    $anti_ddos_protection_enable = true;
}

if ($anti_ddos_protection_enable && isset($_SERVER['REMOTE_ADDR'])) {


    $not_rated_as = '13238,15169,8075,10310,36647,13335,2635,32934,38365,55967,16509,2559,19500,47764,17012,1449,43247,32734,15768,33512,18730,30148';

    $remote_ip = $_SERVER['REMOTE_ADDR'];
    $secure_cookie_label = 'ct_anti_ddos_key';

   
    $secure_cookie_salt = '4xU9mn2X7iPZpeW2';

    $secure_cookie_key = md5($remote_ip . ':' . $secure_cookie_salt);


    $secure_cookie_days = 180;

    $redirect_delay = 3;
    
    $test_ip = true;
    $set_secure_cookie = true;
    if (isset($_COOKIE[$secure_cookie_label]) && $_COOKIE[$secure_cookie_label] == $secure_cookie_key) {
        $test_ip = false;
        $set_secure_cookie = false;
    }
  
    $skip_trusted = false;
    if ($test_ip && function_exists('geoip_org_by_name')) {
        $visitor_org = geoip_org_by_name($remote_ip);
        if ($visitor_org !== false && preg_match("/^AS(\d+)\s/", $visitor_org, $matches)) {
            $not_rated_as = explode(",", $not_rated_as);
            foreach ($not_rated_as as $asn) {
                if ($skip_trusted) {
                    continue;
                }
                if ($asn == $matches[1]) {
                    $skip_trusted = true;
                }
            }
            if ($skip_trusted) {
                if ($anti_ddos_debug) {
                    error_log(sprintf('Skip antiddos protection for %s, because it\'s trusted AS%d.', $remote_ip, $asn));
                }
                $test_ip = false;
            }
        }
    }
		

    if ($test_ip === true && $test_not_rated_ua === true) {
        require "not_rated_ua.php"; 
        if (isset($_SERVER['HTTP_USER_AGENT']) && count($not_rated_ua) > 0) {
            foreach ($not_rated_ua as $ua) {
                if (preg_match("/^$ua$/", $_SERVER['HTTP_USER_AGENT'])) {
                    if ($anti_ddos_debug) {
                        error_log(sprintf('Skip antiddos protection for %s, because it\'s trusted User-Agent %s.', $remote_ip, $ua));
                    }
                    $test_ip = false;
                }
            }
        }
    }

    $run_stop_action = $test_ip;
    if ($run_stop_action) {
        $html_file = file_get_contents(dirname(__FILE__) . '/cf.html');
        echo sprintf($html_file, 
            $remote_ip,
            $remote_ip,
            $redirect_delay,
            $secure_cookie_days,
            $secure_cookie_label,
            $secure_cookie_key,
            $redirect_delay * 1000
        );
        if ($anti_ddos_debug) {
            error_log(sprintf('IP Blacklisted #LuisSec #NeverDown %s.', 
                $remote_ip,
                $_SERVER['REQUEST_URI']
            ));
        }

        exit; 
    } 
    if ($set_secure_cookie && !$run_stop_action) {
        setcookie($secure_cookie_label, $secure_cookie_key, null, '/');
    }
}






  
?>

<!DOCTYPE html>
  <style>
   .u-section-1 {
  background-image: none;
}

.u-section-1 .u-sheet-1 {
  min-height: 887px;
}

.u-section-1 .u-btn-1 {
  border-style: none;
  font-weight: 700;
  text-transform: uppercase;
  font-size: 0.875rem;
  letter-spacing: 0px;
  background-image: linear-gradient(to right, #232323, #666666);
  margin: 62px auto 0 0;
  padding: 145px 100px 146px 99px;
}

.u-section-1 .u-icon-1 {
  width: 54px;
  height: 54px;
  --animation-custom_in-translate_x: -200px;
  --animation-custom_in-translate_y: 0px;
  --animation-custom_in-opacity: 0;
  --animation-custom_in-rotate: 0deg;
  --animation-custom_in-scale: 1;
  margin: -195px auto 0 24px;
  padding: 0;
}

.u-section-1 .u-btn-2 {
  background-image: linear-gradient(to right, #999999, #e5e5e5);
  border-style: none;
  font-weight: 700;
  text-transform: uppercase;
  font-size: 0.875rem;
  letter-spacing: 0px;
  margin: -195px 0 0 auto;
  padding: 145px 100px 146px;
}

.u-section-1 .u-icon-2 {
  width: 54px;
  height: 54px;
  --animation-custom_in-translate_x: -200px;
  --animation-custom_in-translate_y: 0px;
  --animation-custom_in-opacity: 0;
  --animation-custom_in-rotate: 0deg;
  --animation-custom_in-scale: 1;
  margin: -195px 186px 0 auto;
  padding: 0;
}

.u-section-1 .u-btn-3 {
  background-image: linear-gradient(#f1c50e, #e68387);
  border-style: none;
  font-weight: 700;
  text-transform: uppercase;
  font-size: 0.875rem;
  letter-spacing: 0px;
  margin: -195px auto 0;
  padding: 146px 100px;
}

.u-section-1 .u-icon-3 {
  width: 54px;
  height: 54px;
  --animation-custom_in-translate_x: -200px;
  --animation-custom_in-translate_y: 0px;
  --animation-custom_in-opacity: 0;
  --animation-custom_in-rotate: 0deg;
  --animation-custom_in-scale: 1;
  margin: -196px auto 0 476px;
  padding: 0;
}

.u-section-1 .u-btn-4 {
  background-image: linear-gradient(to right, #0083ff, #003a98);
  border-style: none;
  font-weight: 700;
  text-transform: uppercase;
  font-size: 0.875rem;
  letter-spacing: 0px;
  margin: 216px auto 0 0;
  padding: 145px 101px 146px 100px;
}

.u-section-1 .u-icon-4 {
  width: 54px;
  height: 54px;
  --animation-custom_in-translate_x: -200px;
  --animation-custom_in-translate_y: 0px;
  --animation-custom_in-opacity: 0;
  --animation-custom_in-rotate: 0deg;
  --animation-custom_in-scale: 1;
  margin: -194px auto 0 30px;
  padding: 0;
}

.u-section-1 .u-btn-5 {
  background-image: linear-gradient(to right, #005111, #38c900);
  border-style: none;
  font-weight: 700;
  text-transform: uppercase;
  font-size: 0.875rem;
  letter-spacing: 0px;
  margin: -196px auto 0;
  padding: 146px 100px;
}

.u-section-1 .u-icon-5 {
  width: 54px;
  height: 54px;
  --animation-custom_in-translate_x: -200px;
  --animation-custom_in-translate_y: 0px;
  --animation-custom_in-opacity: 0;
  --animation-custom_in-rotate: 0deg;
  --animation-custom_in-scale: 1;
  margin: -195px auto 0 470px;
  padding: 0;
}

.u-section-1 .u-btn-6 {
  background-image: linear-gradient(to right, #6b4748, #fb0000);
  border-style: none;
  font-weight: 700;
  text-transform: uppercase;
  font-size: 0.875rem;
  letter-spacing: 0px;
  margin: -197px -1px 0 auto;
  padding: 146px 101px 148px 100px;
}

.u-section-1 .u-icon-6 {
  width: 54px;
  height: 54px;
  --animation-custom_in-translate_x: -200px;
  --animation-custom_in-translate_y: 0px;
  --animation-custom_in-opacity: 0;
  --animation-custom_in-rotate: 0deg;
  --animation-custom_in-scale: 1;
  margin: -196px 174px 0 auto;
  padding: 0;
}

.u-section-1 .u-custom-html-1 {
  margin-top: 218px;
  margin-bottom: 1px;
}

@media (max-width: 1199px) {
  .u-section-1 .u-icon-3 {
    margin-left: 393px;
  }

  .u-section-1 .u-icon-5 {
    margin-left: 388px;
  }

  .u-section-1 .u-btn-6 {
    margin-right: 0;
  }
}

@media (max-width: 991px) {
  .u-section-1 .u-icon-2 {
    margin-right: 174px;
  }

  .u-section-1 .u-icon-3 {
    width: 44px;
    height: 44px;
    margin-top: -186px;
    margin-left: 274px;
  }

  .u-section-1 .u-icon-5 {
    margin-top: -196px;
    margin-left: 264px;
  }

  .u-section-1 .u-btn-6 {
    margin-top: -196px;
  }
}

@media (max-width: 767px) {
  .u-section-1 .u-icon-3 {
    margin-left: 206px;
  }

  .u-section-1 .u-icon-5 {
    margin-left: 198px;
  }
}

@media (max-width: 575px) {
  .u-section-1 .u-btn-1 {
    margin-top: 50px;
    margin-left: auto;
    padding-top: 10px;
    padding-right: 101px;
    padding-bottom: 10px;
  }

  .u-section-1 .u-icon-1 {
    margin-top: -57px;
    margin-left: 68px;
  }

  .u-section-1 .u-btn-2 {
    margin-top: 19px;
    margin-right: auto;
    padding-top: 8px;
    padding-bottom: 10px;
  }

  .u-section-1 .u-icon-2 {
    margin-top: -54px;
    margin-right: auto;
    margin-left: 68px;
  }

  .u-section-1 .u-btn-3 {
    margin-top: 93px;
    padding-top: 8px;
    padding-right: 101px;
    padding-bottom: 10px;
  }

  .u-section-1 .u-icon-3 {
    margin-top: -47px;
    margin-left: 73px;
  }

  .u-section-1 .u-btn-4 {
    margin-top: -141px;
    margin-left: auto;
    padding-top: 11px;
    padding-bottom: 13px;
  }

  .u-section-1 .u-icon-4 {
    margin-top: -61px;
    margin-left: 68px;
  }

  .u-section-1 .u-btn-5 {
    margin-top: 99px;
    padding-top: 9px;
    padding-bottom: 10px;
  }

  .u-section-1 .u-icon-5 {
    margin-top: -59px;
    margin-left: 68px;
  }

  .u-section-1 .u-btn-6 {
    margin-top: 19px;
    margin-right: auto;
    padding-top: 9px;
    padding-right: 102px;
    padding-bottom: 11px;
  }

  .u-section-1 .u-icon-6 {
    margin-top: -60px;
    margin-right: auto;
    margin-left: 68px;
  }

  .u-section-1 .u-custom-html-1 {
    margin-top: 386px;
    margin-bottom: 0;
  }
}
    </style>
<html style="font-size: 16px;" lang="es"><head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <meta name="keywords" content="">
    <meta name="description" content="#CodedbyLuis">
    <title>LuisNet</title>
    <link rel="stylesheet" href="https://cloud.luisweb.cf/cloud/css4/nicepage.css" media="screen">
<link rel="stylesheet" href="https://cloud.luisweb.cf/cloud/css5/Server-selector2.css" media="screen">
    <script class="u-script" type="text/javascript" src="https://cloud.luisweb.cf/cloud/css4/jquery.js" defer=""></script>
    <script class="u-script" type="text/javascript" src="https://cloud.luisweb.cf/cloud/css4/nicepage.js" defer=""></script>
    <meta property="og:title" content="Cloud selector">
    <meta property="og:description" content="#CodedbyLuis">
    <meta property="og:url" content="https://luisweb.cf/cloud">
    <link id="u-theme-google-font" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i|Open+Sans:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i">
    
    
    <script type="application/ld+json">{
		"@context": "http://schema.org",
		"@type": "Organization",
		"name": ""
}</script>
    <meta name="theme-color" content="#478ac9">
    <meta property="og:type" content="website">
  </head>
  <body data-home-page="Server-selector2.html" data-home-page-title="Server selector2" class="u-body u-xl-mode">
    <section class="u-black u-clearfix u-section-1" id="sec-334c">
      <div class="u-clearfix u-sheet u-sheet-1">
        <a href="https://luisweb.cf/servers/c/" class="u-align-left u-border-none u-btn u-button-style u-gradient u-none u-text-body-alt-color u-btn-1" data-animation-name="bounceIn" data-animation-duration="1000" data-animation-direction="">cARBON<br>sERVER
        </a><span class="u-file-icon u-icon u-text-white u-icon-1" data-animation-name="customAnimationIn" data-animation-duration="1000"><img src="https://cloud.luisweb.cf/cloud/css5/550291.png" alt=""></span>
        <a href="https://luisweb.cf/cloud/error" class="u-border-none u-btn u-button-style u-gradient u-none u-text-body-alt-color u-btn-2" data-animation-name="bounceIn" data-animation-duration="1000" data-animation-direction="">lITHIUM<br>SERVER
        </a><span class="u-file-icon u-icon u-icon-2" data-animation-name="customAnimationIn" data-animation-duration="1000"><img src="https://cloud.luisweb.cf/cloud/css5/3463455.png" alt=""></span>
        <a href="https://luisweb.cf/cloud/error" class="u-align-center u-border-none u-btn u-button-style u-gradient u-none u-text-body-alt-color u-btn-3" data-animation-name="bounceIn" data-animation-duration="1000" data-animation-direction="">nEON<br>SERVER
        </a><span class="u-file-icon u-icon u-text-white u-icon-3" data-animation-name="customAnimationIn" data-animation-duration="1000"><img src="https://cloud.luisweb.cf/cloud/css5/8002526.png" alt=""></span>
        <a href="https://luisweb.cf/cloud/error" class="u-align-left u-border-none u-btn u-button-style u-gradient u-none u-text-body-alt-color u-btn-4" data-animation-name="bounceIn" data-animation-duration="1000" data-animation-direction="">cOBALT<br>sERVER
        </a><span class="u-file-icon u-icon u-icon-4" data-animation-name="customAnimationIn" data-animation-duration="1000"><img src="https://cloud.luisweb.cf/cloud/css5/7734417.png" alt=""></span>
        <a href="https://cloud.luisweb.cf/n1cloud" class="u-align-center u-border-none u-btn u-button-style u-gradient u-none u-text-body-alt-color u-btn-5" data-animation-name="bounceIn" data-animation-duration="1000" data-animation-direction="">sHARED<br>SERVER
        </a><span class="u-file-icon u-icon u-icon-5" data-animation-name="customAnimationIn" data-animation-duration="1000" data-animation-direction=""><img src="https://cloud.luisweb.cf/cloud/css5/7047312.png" alt=""></span>
        <a href="https://cloud.luisweb.cf/n2cloud" class="u-border-none u-btn u-button-style u-gradient u-none u-text-body-alt-color u-btn-6" data-animation-name="bounceIn" data-animation-duration="1000" data-animation-direction="">pRIVATE<br>SERVER
        </a><span class="u-file-icon u-icon u-icon-6" data-animation-name="customAnimationIn" data-animation-duration="1000" data-animation-direction=""><img src="https://cloud.luisweb.cf/cloud/css5/891399.png" alt=""></span>
      </div>
    </section>
    
    
    
  
</body></html>
