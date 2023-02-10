<?php
include_once('Db.php');
include_once('Utils.php');
include_once('credentials.php');

function loadConfig() {
if(file_exists('config.ini'))
    {
      $config = parse_ini_file("config.ini");
      return array("orderID" => $config["orderID"]);
    } else
    return array();
}

$configData = loadConfig();

$content = Db::queryOne('SELECT aboutus.*, contacts.*, metatags.*, domains.*, cta.*, headlines.*, opening_time.* FROM aboutus 
          LEFT JOIN contacts ON aboutus.order_id = contacts.order_id
          LEFT JOIN metatags ON aboutus.order_id = metatags.order_id
          LEFT JOIN domains ON aboutus.order_id = domains.order_id
          LEFT JOIN cta ON aboutus.order_id = cta.order_id
          LEFT JOIN headlines ON aboutus.order_id = headlines.order_id
          LEFT JOIN opening_time ON aboutus.order_id = opening_time.order_id
          WHERE aboutus.order_id = ?', array($configData['orderID']));

$features = Db::queryAll('SELECT * FROM `features` WHERE `order_id` = ?', array($configData['orderID']));
$faqs = Db::queryAll('SELECT * FROM `faq` WHERE `order_id` = ?', array($configData['orderID']));
$services = Db::queryAll('SELECT * FROM `services` WHERE `order_id` = ?', array($configData['orderID']));
?>
<!doctype html>
<html lang="cs">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?= $content['meta_title'] ?></title>
  <meta name="description" content="<?= $content['meta_description']?>">
  <meta name="keywords" content="<?= $content['meta_keywords']?>">
  	<!-- For Facebook -->
	<meta property="og:title" content="<?= $content['og_title']?>" /> <!-- max. 88 characters-->
	<meta property="og:type" content="<?= $content['og_description']?>" /> 
	<meta property="og:image" content="images/drako_facebook_og.png">
	<meta property="og:url" content="https://<?= $content['domain']?>" />
	<meta property="og:description" content="Začněte s levným webem a navyšujte dle potřeby!" /> <!-- around 200 characters-->
	<meta property="og:locale" content="cs_CZ" />

	<link rel="canonical" href="https://<?= $content['domain']?>" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
  <!-- font awesome 6 free -->
  <script src="https://kit.fontawesome.com/a4fa5c84b6.js" crossorigin="anonymous"></script>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">

  <!-- Poppins font from Google -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="assets/css/app.css">

  
</head>
<!-- Google tag (gtag.js) -->
<?= $content['g_analytics']?>
<!-- End Google tag (gtag.js) -->
<body>
  <!--Hero ====================================== -->
  <header class="hero container-fluid border-bottom ">
    <nav class="hero-nav py-2 border-bottom mx-auto">
      <ul class="nav w-100 list-unstyled align-items-center p-0">
        <li class="hero-nav__item">
          <a href="./">
          <span class="hero-nav__logo"><i class="fas fa-dumbbell pe-2"></i><?= $content['c_brand'] ?></span></a>
        </li>
        <li id="hero-menu" class="flex-grow-1 hero__nav-list hero__nav-list--mobile-menu ft-menu">
          <ul class="hero__menu-content nav flex-column flex-lg-row ft-menu__slider animated list-unstyled p-2 p-lg-0">
            <li class="flex-grow-1">
              <ul class="nav nav--lg-side list-unstyled align-items-center p-0">
                <li class="hero-nav__item">
                  <a href="#contact-us" class="hero-nav__link">Kontakt</a>
                </li>

                <li class="hero-nav__item">
                  <a href="#faq" class="hero-nav__link">FAQ</a>
                </li>
                <li class="hero-nav__item">
                  <a href="#pricing" class="hero-nav__link">Ceník</a>
                </li>
                <li class="hero-nav__item">
                  <a href="#product" class="hero-nav__link">Služby</a>
                </li>
                <li class="hero-nav__item">
                  <a href="#aboutus" class="hero-nav__link">O nás</a>
                </li>
                <li class="hero-nav__item">
                  <a href="#" class="hero-nav__link active">Úvod</a>
                </li>
              </ul>
            </li>
          </ul>
          <button onclick="document.querySelector('#hero-menu').classList.toggle('ft-menu--js-show')"
            class="ft-menu__close-btn animated">
            <svg class="bi bi-x" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M11.854 4.146a.5.5 0 010 .708l-7 7a.5.5 0 01-.708-.708l7-7a.5.5 0 01.708 0z"
                clip-rule="evenodd" />
              <path fill-rule="evenodd" d="M4.146 4.146a.5.5 0 000 .708l7 7a.5.5 0 00.708-.708l-7-7a.5.5 0 00-.708 0z"
                clip-rule="evenodd" />
            </svg>
          </button>
        </li>
        <li class="d-lg-none flex-grow-1 d-flex flex-row-reverse hero-nav__item">
          <button onclick="document.querySelector('#hero-menu').classList.toggle('ft-menu--js-show')"
            class="text-center px-2">
            <i class="fas fa-bars"></i>
          </button>
        </li>
      </ul>
    </nav>
    <div class="hero__content container">
      <div class="row g-5">
        <div class="col-lg-6 d-flex flex-column align-items-start justify-content-center">
          <h1 class="hero__title mb-3">
          <?= $content['hero_title']?>
          </h1>
          <p class="hero__paragraph mb-5">
          <?= $content['hero_subtitle']?>
          </p>
          <p>
            <?= Utils::buttonCTA($configData['orderID'], $content['web_target']) ?>
          </p>
          
        </div>
        <div class="col-lg-6">
          <div class="d-flex align-self-end">
            <img src="https://www.stanislav-drako.cz/public/img/hero.svg" class="hero__img w-100">
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- ===================================== -->

  <div id="aboutus" class="block-5 space-between-blocks">
    <div class="container">
      <div class="row g-5">
      <!-- HEADER -->
      <div class="col-lg-6 order-2 order-lg-0">
                <!-- IMAGE -->
        <div class="d-flex">
          <img src="https://www.stanislav-drako.cz/public/img/hero2.svg" class="w-100">
        </div>
      </div>
      <div class="col-lg-6 d-flex flex-column justify-content-center align-items-end order-1">
        <p class="block__pre-title mb-2"><?= $content['about_subtitle'] ?></p>
        <h2 class="block__title mb-3 text-end">
          <?= $content['about_title'] ?></h2>
        <p class="block__paragraph text-end">
            <?= $content['about_content'] ?>
        </p>
        <p class="mt-3"><?= Utils::buttonCTA($configData['orderID'], $content['web_target']) ?></p>
      </div>
    </div>
  </div>
  </div>
<div>
<div class="container block-17" id="product">
  <div class="row g-5 d-flex justify-content-center">
    <div class="col-12">
      <div class="col-lg-8 text-center mx-auto">
        <h2 class="block__title mb-3"><?= $content['feat_headline'] ?></h2>
        <p class="block__paragraph">
          <?= $content['feat_subheadline'] ?>
        </p>
      </div>
    </div>
      <!-- LEFT CONTENT -->
      <?php foreach($features as $f) : ?>
      <div class="col-lg-4">
        <div class="card-2 d-flex flex-column gap-3 h-100">
          <div class="align-self-center">
            <span class="card-2__symbol">
              <i class="fas fa-dumbbell"></i>
            </span>
          </div>            
          <div>
            <h3 class="card-2__title mb-2 text-center"><?= $f['f_title'] ?></h3>
            <p class="block__paragraph text-center">
            <?= $f['f_content'] ?>
            </p>
          </div>
        </div>          
      </div>
      <?php endforeach ; ?>

    </div>
  </div>
</div>
<div id="cta">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 testimonial-card-3">
        <div class="d-flex flex-column justify-content-center align-items-center gap-3">
          <div class="col-lg-6">
            <h2 class="block__title text-center"><?= $content['cta_title'] ?></h2>
            <p class="block__paragraph text-center"><?= $content['cta_subtitle'] ?></p>
          </div>
          <p class="mt-3 shadow-lg rounded-circle"><?= Utils::buttonCTA($configData['orderID'], $content['web_target']) ?></p>
        </div>

      </div>
    </div>
  </div>
</div>
  <!-- ===================================== -->
  <div id="pricing" class="block-17 px-4 space-between-blocks">
    <div class="container">
      <div class="block-17__header col-lg-8 col-xl-7 mx-auto text-center px-0">
        <h1 class="block__title mb-3"><?= $content['price_headline'] ?></h1>
        <p class="block__paragraph">
          <?= $content['price_subheadline'] ?>
        </p>
      </div>
      <div class="row justify-content-center g-5">

      <?php foreach($services as $s) : ?>
          <div class="col-md-4">
            <div class="card-1 card-1--selected text-center d-flex flex-column gap-2 h-100">
              <span class="card-1__symbol mx-auto">
                <i class="fas fa-dumbbell"></i>
              </span>
              <h3 class="card-1__title mb-2"><?= $s['services_title']?></h3>
              <p class="card-1__paragraph">
                <?= $s['services_content']?>
              </p>
              <span class="fw-bold"><?= $s['services_price']?></span>
            </div>            
          </div>
        <?php endforeach; ?>

      </div>
    </div>
  </div>

  <!-- =================================== -->

  <div id="faq" class="block-20 space-between-blocks">
    <div class="container">
      <!-- HEADER -->
      <div class="block__header col-lg-8 col-xl-7 mx-auto text-center">
        <p class="block__pre-title mb-2">FAQ</p>
        <h1 class="block__title mb-3"><?= $content['faq_headline'] ?></h1>
        <p class="block__paragraph mb-0">
        <?= $content['faq_subheadline'] ?>
        </p>
      </div>
      <div class="row g-5">
        <div class="col-lg-6">
        <img class="w-100" src="https://www.stanislav-drako.cz/public/img/hero3.svg">
        </div>
        <div class="col-lg-6">
          <div class="accordion accordion-flush" id="accordionExample">
                <?php foreach($faqs as $faq) : ?>
                <div class="accordion-item">
                    <h2 class="accordion-header " id="heading<?= $faq['id'] ?>">
                    <button class="accordion-button collapsed card-1--selected card-1__title" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?= $faq['id'] ?>" aria-expanded="false" aria-controls="faq<?= $faq['id'] ?>">                                                        
                        <?= $faq['faq_question'] ?>  
                    </h2>
                    <div id="faq<?= $faq['id'] ?>" class="accordion-collapse collapse" aria-labelledby="heading<?= $faq['id'] ?>" data-bs-parent="#accordionExample">
                        <div class="accordion-body d-flex card-1__paragraph">
                        <?= $faq['faq_answer'] ?>
                        
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
      </div>
      
    </div>
  </div>

  <!-- ======================================== -->


  <!-- =================================== -->

  <div id="contact-us" class="block-17">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 h-100">
          <div class="contact-info col-12 col-md-6">
            <h5 class="contact-info__title mb-3"><?= $content['contact_headline'] ?></h5>
            <p class="contact-info__paragraph mb-5">
            <?= $content['contact_subheadline'] ?>
            </p>
            <div class="mb-3">
              <h6 class="contact-info__title-2 mb-3"><?= $content['c_person'] ?></h6>
              <p class="d-flex flex-column">
                <span class="contact-info__item mb-2"><?= $content['c_address'] ?></span>
                <?php if(!empty($content['c_ico'])) : ?>
                <span class="contact-info__item"><?= 'IČO: ' . $content['c_ico'] ?></span>
                <?php endif; ?>
                <?php if(!empty($content['c_dic'])) : ?>
                <span class="contact-info__item"><?= 'DIČ: ' . $content['c_dic'] ?></span>
                <?php endif; ?>
                <?php if(!empty($content['c_datovka'])) : ?>
                <span class="contact-info__item"><?= 'Datová schránka: ' . $content['c_datovka'] ?></span>
                <?php endif; ?>
              </p>
            </div>
            <div class="mb-5">
              
              <p class="d-flex flex-column">
                <?php if(!empty($content['c_phone'])) : ?>
                <span class="contact-info__item mb-2">
                  <a href="tel:<?= $content['c_phone'] ?>"><i class="fas fa-phone"></i><span class="mx-2"><?= $content['c_phone'] ?></span></a>
                </span>
                <?php endif; ?>
                <?php if(!empty($content['c_phone'])) : ?>
                <span class="contact-info__item">
                  <a href="mailto:<?= $content['c_email'] ?>"><i class="fas fa-envelope"></i><span class="mx-2"><?= $content['c_email'] ?></span></a>
                </span>
                <?php endif; ?>
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
        <?php if(!$content['nonstop']) :  ?> 
          <div class="d-flex flex-column justify-content-center align-items-center h-100 p-4">  
          <div class="col-12 col-md-8 d-flex flex-column gap-3">                          
          <div class="d-flex justify-content-between">
              <span class="headline-color">Pondělí: </span>
              <?php if($content['mon_hour_start']) : ?>
              <div class="d-flex gap-2">
                  <div><span><?= $content['mon_hour_start'] ?></span> : <span><?= $content['mon_min_start'] ?></span></div>
                  <div> - <span><?= $content['mon_hour_end'] ?></span> : <span><?= $content['mon_min_end'] ?></span></div>
              </div>
              <?php else : ?>
                <div><span class="text-danger">Zavřeno</span></div>
              <?php endif; ?>
          </div> 
          <div class="d-flex justify-content-between">
              <span class="headline-color">Úterý: </span>
              <?php if($content['tue_hour_start']) : ?>
              <div class="d-flex gap-2">
                  <div><span><?= $content['tue_hour_start'] ?></span> : <span><?= $content['tue_min_start'] ?></span></div>
                  <div> - <span><?= $content['tue_hour_end'] ?></span> : <span><?= $content['tue_min_end'] ?></span></div>
              </div>
              <?php else : ?>
                <div><span class="text-danger">Zavřeno</span></div>
              <?php endif; ?>
          </div>
          <div class="d-flex justify-content-between">
              <span class="headline-color">Středa: </span>
              <?php if($content['wen_hour_start']) : ?>
              <div class="d-flex gap-2">
                  <div><span><?= $content['wen_hour_start'] ?></span> : <span><?= $content['wen_min_start'] ?></span></div>
                  <div> - <span><?= $content['wen_hour_end'] ?></span> : <span><?= $content['wen_min_end'] ?></span></div>
              </div>
              <?php else : ?>
                <div><span class="text-danger">Zavřeno</span></div>
              <?php endif; ?>
          </div>     
          <div class="d-flex justify-content-between">
              <span class="headline-color">Čtvrtek: </span>
              <?php if($content['thu_hour_start']) : ?>
              <div class="d-flex gap-2">
                  <div><span><?= $content['thu_hour_start'] ?></span> : <span><?= $content['thu_min_start'] ?></span></div>
                  <div> - <span><?= $content['thu_hour_end'] ?></span> : <span><?= $content['thu_min_end'] ?></span></div>
              </div>
              <?php else : ?>
                <div><span class="text-danger">Zavřeno</span></div>
              <?php endif; ?>
          </div>
          <div class="d-flex justify-content-between">
              <span class="headline-color">Pátek: </span>
              <?php if($content['fri_hour_start']) : ?>
              <div class="d-flex gap-2">
                  <div><span><?= $content['fri_hour_start'] ?></span> : <span><?= $content['fri_min_start'] ?></span></div>
                  <div> - <span><?= $content['fri_hour_end'] ?></span> : <span><?= $content['fri_min_end'] ?></span></div>
              </div>
              <?php else : ?>
                <div><span class="text-danger">Zavřeno</span></div>
              <?php endif; ?>
          </div> 
          <div class="d-flex justify-content-between">
              <span class="headline-color">Sobota: </span>
              <?php if($content['sat_hour_start']) : ?>
              <div class="d-flex gap-2">
                  <div><span><?= $content['sat_hour_start'] ?></span> : <span><?= $content['sat_min_start'] ?></span></div>
                  <div> - <span><?= $content['sat_hour_end'] ?></span> : <span><?= $content['sat_min_end'] ?></span></div>
              </div>
              <?php else : ?>
                <div><span class="text-danger">Zavřeno</span></div>
              <?php endif; ?>
          </div>                                                                     
          <div class="d-flex justify-content-between">
              <span class="headline-color">Neděle: </span>
              <?php if($content['sun_hour_start']) : ?>
              <div class="d-flex gap-2">
                  <div><span><?= $content['sun_hour_start'] ?></span> : <span><?= $content['sun_min_start'] ?></span></div>
                  <div> - <span><?= $content['sun_hour_end'] ?></span> : <span><?= $content['sun_min_end'] ?></span></div>
              </div>
              <?php else : ?>
                <div><span class="text-danger">Zavřeno</span></div>
              <?php endif; ?>
          </div> 
          </div>
          </div>
          <?php endif; ?>
      </div>
      </div>
    </div>
  </div>

  <!-- =================================== -->

  <div class="block-44">
    <div class="container">
      <div class="row flex-column flex-md-row px-2 pt-3 justify-content-center">
        <div class="col-12 col-md-6">
          <ul class="block-44__extra-links d-flex list-unstyled p-0">
            <?php if(!empty($content['c_facebook'])) : ?>
              <li class="mx-2">
              <a href="<?=$content['c_facebook']?>" class="block-44__link m-0">
                <i class="fab fa-facebook"></i>
              </a>
            </li>
            <?php endif; ?>
            <?php if(!empty($content['c_twitter'])) : ?>
            <li class="mx-2">
              <a href="<?= $content['c_twitter'] ?>" class="block-44__link m-0">
                <i class="fab fa-twitter"></i>
              </a>
            </li>
            <?php endif; ?>
            <?php if(!empty($content['c_instagram'])) : ?>
            <li class="mx-2">
              <a href="<?= $content['c_instragram'] ?>" class="block-44__link m-0">
                <i class="fab fa-instagram"></i>
              </a>
            </li>
            <?php endif; ?>
            <?php if(!empty($content['c_youtube'])) : ?>
            <li class="mx-2">
              <a href="<?= $content['c_youtube'] ?>" class="block-44__link m-0">
                <i class="fab fa-youtube"></i>
              </a>
            </li>
            <?php endif; ?>
            <?php if(!empty($content['c_discord'])) : ?>
            <li class="mx-2">
              <a href="<?= $content['c_discord'] ?>" class="block-44__link m-0">
                <i class="fab fa-discord"></i>
              </a>
            </li>
            <?php endif; ?>
            <?php if(!empty($content['c_linkedin'])) : ?>
            <li class="mx-2">
              <a href="<?= $content['c_linkedin'] ?>" class="block-44__link m-0">
                <i class="fab fa-linkedin"></i>
              </a>
            </li>
            <?php endif; ?>
            <?php if(!empty($content['c_mastodon'])) : ?>
            <li class="mx-2">
              <a href="<?= $content['c_mastodon'] ?>" class="block-44__link m-0">
                <i class="fab fa-mastodon"></i>
              </a>
            </li>
            <?php endif; ?>
          </ul>
          
        </div>
        <div class="col-md-6">
          <p class="block-41__copyrights">&copyCopyright 2022 - <?= date('Y')?>. Vytvořil s láskou <a href="https://www.stanislav-drako.cz">Stanislav Drako</a></p>
        </div>
        
      </div>
    </div>
  </div>

  <!-- =================================== -->

  <script src="assets/app.js"></script>

  <script src="assets/bootstrap.bundle.min.js"></script>

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>


</body>

</html>
