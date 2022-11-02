<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* stroimarket/template/common/header.twig */
class __TwigTemplate_6e5f6c20e616e93e8ec5c5c012028ff34aae116b3f17da935089f61eb85ef81c extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]>
<html dir=\"";
        // line 4
        echo ($context["direction"] ?? null);
        echo "\" lang=\"";
        echo ($context["lang"] ?? null);
        echo "\" class=\"ie8\">
  <![endif]-->
  <!--[if IE 9 ]>
  <html dir=\"";
        // line 7
        echo ($context["direction"] ?? null);
        echo "\" lang=\"";
        echo ($context["lang"] ?? null);
        echo "\" class=\"ie9\">
    <![endif]-->
    <!--[if (gt IE 9)|!(IE)]><!-->
    <html dir=\"";
        // line 10
        echo ($context["direction"] ?? null);
        echo "\" lang=\"";
        echo ($context["lang"] ?? null);
        echo "\">
      <!--<![endif]-->
      <head>
        <meta charset=\"UTF-8\" />
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <title>";
        // line 16
        echo ($context["title"] ?? null);
        echo "</title>
        ";
        // line 17
        if (($context["robots"] ?? null)) {
            // line 18
            echo "        <meta name=\"robots\" content=\"";
            echo ($context["robots"] ?? null);
            echo "\" />
        ";
        }
        // line 20
        echo "        ";
        if (($context["canons"] ?? null)) {
            // line 21
            echo "        <!--<meta name=\"canonical\" content=\"";
            echo ($context["canons"] ?? null);
            echo "\" />-->
        ";
        }
        // line 23
        echo "        <base href=\"";
        echo ($context["base"] ?? null);
        echo "\" />
        ";
        // line 24
        if (($context["description"] ?? null)) {
            // line 25
            echo "        <meta name=\"description\" content=\"";
            echo ($context["description"] ?? null);
            echo "\" />
        ";
        }
        // line 27
        echo "        ";
        if (($context["keywords"] ?? null)) {
            // line 28
            echo "        <meta name=\"keywords\" content=\"";
            echo ($context["keywords"] ?? null);
            echo "\" />
        ";
        }
        // line 30
        echo "        <meta property=\"og:title\" content=\"";
        echo ($context["title"] ?? null);
        echo "\" />
        <meta property=\"og:type\" content=\"website\" />
        <meta property=\"og:url\" content=\"";
        // line 32
        echo ($context["og_url"] ?? null);
        echo "\" />
        ";
        // line 33
        if (($context["og_image"] ?? null)) {
            // line 34
            echo "        <meta property=\"og:image\" content=\"";
            echo ($context["og_image"] ?? null);
            echo "\" />
        ";
        } else {
            // line 36
            echo "        <meta property=\"og:image\" content=\"";
            echo ($context["logo"] ?? null);
            echo "\" />
        ";
        }
        // line 38
        echo "        <meta property=\"og:site_name\" content=\"";
        echo ($context["name"] ?? null);
        echo "\" />
        <script src=\"catalog/view/javascript/jquery/jquery-2.1.1.min.js\"></script>
        <script src=\"catalog/view/javascript/bootstrap/js/bootstrap.min.js\"></script>
        <script src=\"catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js\"></script>
        <link href=\"catalog/view/javascript/font-awesome/css/font-awesome.min.css\" rel=\"stylesheet\" />
        <link href=\"catalog/view/theme/stroimarket/stylesheet/stylesheet.min.css\" rel=\"stylesheet\">
        <link href=\"catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.css\" rel=\"stylesheet\">
\t\t<link href=\"catalog/view/javascript/jquery/owl-carousel/owl.theme.default.min.css\" rel=\"stylesheet\">
        <link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">
        <link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>
        <link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap\" rel=\"stylesheet\">
        ";
        // line 49
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["styles"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["style"]) {
            // line 50
            echo "        <link href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["style"], "href", [], "any", false, false, false, 50);
            echo "\" type=\"text/css\" rel=\"";
            echo twig_get_attribute($this->env, $this->source, $context["style"], "rel", [], "any", false, false, false, 50);
            echo "\" media=\"";
            echo twig_get_attribute($this->env, $this->source, $context["style"], "media", [], "any", false, false, false, 50);
            echo "\" />
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['style'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 52
        echo "        ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["scripts"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["script"]) {
            // line 53
            echo "        <script src=\"";
            echo $context["script"];
            echo "\"></script>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['script'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 55
        echo "        <script src=\"catalog/view/theme/stroimarket/js/common.min.js\"></script>
        ";
        // line 56
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["links"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 57
            echo "        <link href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["link"], "href", [], "any", false, false, false, 57);
            echo "\" rel=\"";
            echo twig_get_attribute($this->env, $this->source, $context["link"], "rel", [], "any", false, false, false, 57);
            echo "\" />
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['link'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 59
        echo "        ";
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["analytics"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["analytic"]) {
            // line 60
            echo "        ";
            echo $context["analytic"];
            echo "
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['analytic'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 62
        echo "      </head>
      <body>
        <!--<div class=\"warn\">В связи с нестабильным курсом и кратно возросшим спросом - принимаем заказы на сумму от 40 т.р., актуальные цены и наличие - просьба уточнять по телефону или на What's App - +7 (499) 380-64-12</div>-->
        <div class=\"site-main\">
          <div class=\"top-menu__wrapper\">
            <div class=\"container\">
              <div class=\"d-flex justify-content-between\">
                <div class=\"top-blocks top-left\">
                  ";
        // line 70
        if (($context["informations"] ?? null)) {
            // line 71
            echo "                  <ul class=\"horizontal-menu\">
                    ";
            // line 72
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["informations"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["information"]) {
                // line 73
                echo "                    <li><a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["information"], "href", [], "any", false, false, false, 73);
                echo "\">";
                echo twig_get_attribute($this->env, $this->source, $context["information"], "title", [], "any", false, false, false, 73);
                echo "</a></li>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['information'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 74
            echo "\t\t\t  
                    <li><a href=\"/contact-us\">Шоурум - ул. Енисейская, д. 11</a></li>
                  </ul>
                  ";
        }
        // line 78
        echo "                </div>
                <div class=\"top-blocks top-right\">
                  <div class=\"top-info__blocks d-flex align-items-center\">
                    ";
        // line 81
        echo ($context["currency"] ?? null);
        echo "
                    ";
        // line 82
        echo ($context["language"] ?? null);
        echo "
                    <div class=\"header-phone\">
                        <span class=\"whatsapp32-mob visible-xs\"><a href=\"https://api.whatsapp.com/send/?phone=74993481116&text=Добрый+день%2C+вышлите+предложение+по+<?php echo \$heading_title; ?>\">Перейти в чат 
                    <svg height=\"13pt\" viewBox=\"-1 0 512 512\" width=\"13pt\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"m10.894531 512c-2.875 0-5.671875-1.136719-7.746093-3.234375-2.734376-2.765625-3.789063-6.78125-2.761719-10.535156l33.285156-121.546875c-20.722656-37.472656-31.648437-79.863282-31.632813-122.894532.058594-139.941406 113.941407-253.789062 253.871094-253.789062 67.871094.0273438 131.644532 26.464844 179.578125 74.433594 47.925781 47.972656 74.308594 111.742187 74.289063 179.558594-.0625 139.945312-113.945313 253.800781-253.867188 253.800781 0 0-.105468 0-.109375 0-40.871093-.015625-81.390625-9.976563-117.46875-28.84375l-124.675781 32.695312c-.914062.238281-1.84375.355469-2.761719.355469zm0 0\" fill=\"#01e675\"/><path d=\"m10.894531 501.105469 34.46875-125.871094c-21.261719-36.839844-32.445312-78.628906-32.429687-121.441406.054687-133.933594 109.046875-242.898438 242.976562-242.898438 64.992188.027344 125.996094 25.324219 171.871094 71.238281 45.871094 45.914063 71.125 106.945313 71.101562 171.855469-.058593 133.929688-109.066406 242.910157-242.972656 242.910157-.007812 0 .003906 0 0 0h-.105468c-40.664063-.015626-80.617188-10.214844-116.105469-29.570313zm134.769531-77.75 7.378907 4.371093c31 18.398438 66.542969 28.128907 102.789062 28.148438h.078125c111.304688 0 201.898438-90.578125 201.945313-201.902344.019531-53.949218-20.964844-104.679687-59.09375-142.839844-38.132813-38.160156-88.832031-59.1875-142.777344-59.210937-111.394531 0-201.984375 90.566406-202.027344 201.886719-.015625 38.148437 10.65625 75.296875 30.875 107.445312l4.804688 7.640625-20.40625 74.5zm0 0\" fill=\"#fff\"/><path d=\"m19.34375 492.625 33.277344-121.519531c-20.53125-35.5625-31.324219-75.910157-31.3125-117.234375.050781-129.296875 105.273437-234.488282 234.558594-234.488282 62.75.027344 121.644531 24.449219 165.921874 68.773438 44.289063 44.324219 68.664063 103.242188 68.640626 165.898438-.054688 129.300781-105.28125 234.503906-234.550782 234.503906-.011718 0 .003906 0 0 0h-.105468c-39.253907-.015625-77.828126-9.867188-112.085938-28.539063zm0 0\" fill=\"#01e675\"/><g fill=\"#fff\"><path d=\"m10.894531 501.105469 34.46875-125.871094c-21.261719-36.839844-32.445312-78.628906-32.429687-121.441406.054687-133.933594 109.046875-242.898438 242.976562-242.898438 64.992188.027344 125.996094 25.324219 171.871094 71.238281 45.871094 45.914063 71.125 106.945313 71.101562 171.855469-.058593 133.929688-109.066406 242.910157-242.972656 242.910157-.007812 0 .003906 0 0 0h-.105468c-40.664063-.015626-80.617188-10.214844-116.105469-29.570313zm134.769531-77.75 7.378907 4.371093c31 18.398438 66.542969 28.128907 102.789062 28.148438h.078125c111.304688 0 201.898438-90.578125 201.945313-201.902344.019531-53.949218-20.964844-104.679687-59.09375-142.839844-38.132813-38.160156-88.832031-59.1875-142.777344-59.210937-111.394531 0-201.984375 90.566406-202.027344 201.886719-.015625 38.148437 10.65625 75.296875 30.875 107.445312l4.804688 7.640625-20.40625 74.5zm0 0\"/><path d=\"m195.183594 152.246094c-4.546875-10.109375-9.335938-10.3125-13.664063-10.488282-3.539062-.152343-7.589843-.144531-11.632812-.144531-4.046875 0-10.625 1.523438-16.1875 7.597657-5.566407 6.074218-21.253907 20.761718-21.253907 50.632812 0 29.875 21.757813 58.738281 24.792969 62.792969 3.035157 4.050781 42 67.308593 103.707031 91.644531 51.285157 20.226562 61.71875 16.203125 72.851563 15.191406 11.132813-1.011718 35.917969-14.6875 40.976563-28.863281 5.0625-14.175781 5.0625-26.324219 3.542968-28.867187-1.519531-2.527344-5.566406-4.046876-11.636718-7.082032-6.070313-3.035156-35.917969-17.726562-41.484376-19.75-5.566406-2.027344-9.613281-3.035156-13.660156 3.042969-4.050781 6.070313-15.675781 19.742187-19.21875 23.789063-3.542968 4.058593-7.085937 4.566406-13.15625 1.527343-6.070312-3.042969-25.625-9.449219-48.820312-30.132812-18.046875-16.089844-30.234375-35.964844-33.777344-42.042969-3.539062-6.070312-.058594-9.070312 2.667969-12.386719 4.910156-5.972656 13.148437-16.710937 15.171875-20.757812 2.023437-4.054688 1.011718-7.597657-.503906-10.636719-1.519532-3.035156-13.320313-33.058594-18.714844-45.066406zm0 0\" fill-rule=\"evenodd\"/></g></svg></a></span>

                        <a href=\"#callback\" class=\"callback callback-mobcolr\">Заказ звонка</a>
                      <a href=\"tel:";
        // line 88
        echo ($context["tel"] ?? null);
        echo "\" class=\"phone-link\" title=\"";
        echo ($context["text_phone"] ?? null);
        echo "\">";
        echo ($context["telephone"] ?? null);
        echo "</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class=\"top-panel__wrapper\">
            <div class=\"top-panel catalog-menu__outside\">
              <div class=\"container\">
                <div class=\"top-panel__cols\">
                  <div class=\"top-panel__col top-panel__thead top-panels left-side\">
                    <div class=\"top-panel__cols top-panel__left\">
                      <div class=\"top-panel__col menu-toggle top-panel__menu-icon-container hidden-md hidden-lg\">
                        <div class=\"menu-button__icon\">
                          <div class=\"long line\"></div>
                          <div class=\"long sec line\"></div>
                          <div class=\"short line\"></div>
                        </div>
                      </div>
                      <div class=\"top-panel__col top-panel__logo top-panel__tfoot\">
                        ";
        // line 109
        if (($context["logo"] ?? null)) {
            // line 110
            echo "                        ";
            if ((($context["home"] ?? null) == ($context["og_url"] ?? null))) {
                // line 111
                echo "                        <img src=\"";
                echo ($context["logo"] ?? null);
                echo "\" title=\"";
                echo ($context["name"] ?? null);
                echo "\" alt=\"";
                echo ($context["name"] ?? null);
                echo "\" class=\"img-responsive\" />
                        ";
            } else {
                // line 113
                echo "                        <a href=\"";
                echo ($context["home"] ?? null);
                echo "\"><img src=\"";
                echo ($context["logo"] ?? null);
                echo "\" title=\"";
                echo ($context["name"] ?? null);
                echo "\" alt=\"";
                echo ($context["name"] ?? null);
                echo "\" class=\"img-responsive\" /></a>
                        ";
            }
            // line 115
            echo "                        ";
        } else {
            // line 116
            echo "                        <a href=\"";
            echo ($context["home"] ?? null);
            echo "\">";
            echo ($context["name"] ?? null);
            echo "</a>
                        ";
        }
        // line 118
        echo "                      </div>
                      <div class=\"top-panel__col top-panel__informer top-panel__menu-icon-container hidden-md hidden-lg\"><i class=\"fi fi-rr-settings\"></i></div>
                    </div>
                  </div>
                  <div class=\"top-panel__col top-panel__tfoot top-panels right-side\">
                    <div class=\"top-mobile__icons top-panel__cols\">
                      <div class=\"top-panel__col top-panel__btn-catalog\">
                        <button type=\"button\" class=\"btn btn-border catalog-button\"><svg width=\"24\" height=\"24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\" class=\"NSQv\"><path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M5 6a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zm4-1a1 1 0 000 2h12a1 1 0 100-2H9zm0 6a1 1 0 100 2h12a1 1 0 100-2H9zm-1 7a1 1 0 011-1h6a1 1 0 110 2H9a1 1 0 01-1-1zm-4.5-4.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM5 18a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z\" fill=\"currentColor\"></path></svg><span>";
        // line 125
        echo ($context["text_catalog"] ?? null);
        echo "</span></button>
                      </div>
                      <div class=\"top-panel__col top-panel__search-container top-panel__tfoot\">
                        <div class=\"top-panel__search-btn hidden-md hidden-lg\">
                          <span class=\"top-panel__search-icon\"><i class=\"fi fi-rr-search\"></i></span>
                        </div>
                        <div class=\"search-block hidden-xs hidden-sm\">
                          <div class=\"top-panel__search\">";
        // line 132
        echo ($context["search"] ?? null);
        echo "</div>
                        </div>
                      </div>
                      <div class=\"top-panel__col top-panel__compare\">
                        <div class=\"mini-cart\">
                          <a href=\"";
        // line 137
        echo ($context["compare"] ?? null);
        echo "\" class=\"panel-compare ";
        echo (((($context["compare_total"] ?? null) == "0")) ? ("compare-empty") : (""));
        echo "\" id=\"compare-total\">
                            <i class=\"fi fi-rr-duplicate\"></i>
                            <span class=\"compare-count count\">";
        // line 139
        echo ($context["compare_total"] ?? null);
        echo "</span>
                            <div class=\"top-panel__title\">";
        // line 140
        echo ($context["text_title_compare"] ?? null);
        echo "</div>
                          </a>
                        </div>
                      </div>
                      <div class=\"top-panel__col top-panel__wishlist\">
                        <div class=\"mini-cart\">
                          <a href=\"";
        // line 146
        echo ($context["wishlist"] ?? null);
        echo "\" class=\"panel-wishlist ";
        echo (((($context["wishlist_total"] ?? null) == "0")) ? ("wishlist-empty") : (""));
        echo "\" id=\"wishlist-total\">
                            <i class=\"fi fi-rr-heart\"></i>
                            <span class=\"wishlist-count count\">";
        // line 148
        echo ($context["wishlist_total"] ?? null);
        echo "</span>
                            <div class=\"top-panel__title\">";
        // line 149
        echo ($context["text_title_wishlist"] ?? null);
        echo "</div>
                          </a>
                        </div>
                      </div>
                      <div class=\"top-panel__col top-panel__user\">
                      
                        <div class=\"mini-cart\">
                          <a href=\"";
        // line 156
        echo ($context["account"] ?? null);
        echo "\" class=\"top-panel__user-link\" title=\"";
        echo ($context["text_title_login"] ?? null);
        echo "\">
                            <i class=\"fi fi-rr-user\"></i>
                            <div class=\"top-panel__title\">";
        // line 158
        echo ($context["text_title_login"] ?? null);
        echo "</div>
                          </a>
                        </div>
                      </div>
                      <div class=\"top-panel__col top-panel__mini-cart\">
                        <div class=\"mini-cart\">
                          <a href=\"";
        // line 164
        echo ($context["shopping_cart"] ?? null);
        echo "\" class=\"panel-cart ";
        echo (((($context["cart_total"] ?? null) == "0")) ? ("cart-empty") : (""));
        echo "\">
                            <i class=\"fi fi-rr-shopping-cart\"></i>
                            <span class=\"cart-count count\">";
        // line 166
        echo ($context["cart_total"] ?? null);
        echo "</span>
                            <div class=\"top-panel__title\">";
        // line 167
        echo ($context["text_title_cart"] ?? null);
        echo "</div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class=\"menu-mobile__informations menu-fixed hidden-md hidden-lg\">
            <div class=\"menu-information-container\">
              <div class=\"slide-header\">
                <span class=\"slide-title\">";
        // line 180
        echo ($context["text_menu"] ?? null);
        echo "</span>
                <span class=\"slide-close\"><svg width=\"16\" height=\"16\" fill=\"#172033\" viewBox=\"0 0 16 16\" class=\"icon icon-close\"><path fill-rule=\"evenodd\" d=\"M2.293 2.293a1 1 0 011.414 0l10 10a1 1 0 01-1.414 1.414l-10-10a1 1 0 010-1.414z\" clip-rule=\"evenodd\"></path><path fill-rule=\"evenodd\" d=\"M13.707 2.293a1 1 0 00-1.414 0l-10 10a1 1 0 101.414 1.414l10-10a1 1 0 000-1.414z\" clip-rule=\"evenodd\"></path></svg></span>
              </div>
              <div class=\"menu-informations-blocks\">
                ";
        // line 184
        if (($context["informations"] ?? null)) {
            // line 185
            echo "                <div class=\"mobile-informations menu-info__item\">
                  <div class=\"title-information\">";
            // line 186
            echo ($context["text_info"] ?? null);
            echo "</div>
                  <ul class=\"list-unstyled\">
                    ";
            // line 188
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["informations"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["information"]) {
                // line 189
                echo "                    <li class=\"item-information\"><a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["information"], "href", [], "any", false, false, false, 189);
                echo "\" rel=\"nofollow\">";
                echo twig_get_attribute($this->env, $this->source, $context["information"], "title", [], "any", false, false, false, 189);
                echo "</a></li>
                    ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['information'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 190
            echo "\t\t\t    
                  </ul>
                </div>
                ";
        }
        // line 194
        echo "                <div class=\"mobile-telephone menu-info__item\">
                  <div class=\"title-information\">";
        // line 195
        echo ($context["text_contacts"] ?? null);
        echo "</div>
                  <a href=\"tel:";
        // line 196
        echo ($context["tel"] ?? null);
        echo "\"><span class=\"mobile-information__icon\"><i class=\"fi fi-rr-phone-call\"></i></span> ";
        echo ($context["telephone"] ?? null);
        echo "</a>
                  <a href=\"#callback\" class=\"callback callback-mobcolr\">Заказ звонка</a>
                  ";
        // line 198
        if (($context["email"] ?? null)) {
            // line 199
            echo "                  <a href=\"mailto:";
            echo ($context["email"] ?? null);
            echo "\"><span class=\"mobile-information__icon\"><i class=\"fi fi-rr-envelope\"></i></span> ";
            echo ($context["email"] ?? null);
            echo "</a>
                  ";
        }
        // line 201
        echo "                  <a href=\"";
        echo ($context["contact"] ?? null);
        echo "\"><span class=\"mobile-information__icon\"><i class=\"fi fi-rr-info\"></i></span> ";
        echo ($context["text_contact"] ?? null);
        echo "</a>
                  <div class=\"whatsapp-prod\"><a href=\"https://api.whatsapp.com/send/?phone=74993481116&text=Добрый+день%2C+расскажите+о+действующих+акциях+и+скидках\">Перейти в чат 
<svg height=\"13pt\" viewBox=\"-1 0 512 512\" width=\"13pt\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\"m10.894531 512c-2.875 0-5.671875-1.136719-7.746093-3.234375-2.734376-2.765625-3.789063-6.78125-2.761719-10.535156l33.285156-121.546875c-20.722656-37.472656-31.648437-79.863282-31.632813-122.894532.058594-139.941406 113.941407-253.789062 253.871094-253.789062 67.871094.0273438 131.644532 26.464844 179.578125 74.433594 47.925781 47.972656 74.308594 111.742187 74.289063 179.558594-.0625 139.945312-113.945313 253.800781-253.867188 253.800781 0 0-.105468 0-.109375 0-40.871093-.015625-81.390625-9.976563-117.46875-28.84375l-124.675781 32.695312c-.914062.238281-1.84375.355469-2.761719.355469zm0 0\" fill=\"#01e675\"/><path d=\"m10.894531 501.105469 34.46875-125.871094c-21.261719-36.839844-32.445312-78.628906-32.429687-121.441406.054687-133.933594 109.046875-242.898438 242.976562-242.898438 64.992188.027344 125.996094 25.324219 171.871094 71.238281 45.871094 45.914063 71.125 106.945313 71.101562 171.855469-.058593 133.929688-109.066406 242.910157-242.972656 242.910157-.007812 0 .003906 0 0 0h-.105468c-40.664063-.015626-80.617188-10.214844-116.105469-29.570313zm134.769531-77.75 7.378907 4.371093c31 18.398438 66.542969 28.128907 102.789062 28.148438h.078125c111.304688 0 201.898438-90.578125 201.945313-201.902344.019531-53.949218-20.964844-104.679687-59.09375-142.839844-38.132813-38.160156-88.832031-59.1875-142.777344-59.210937-111.394531 0-201.984375 90.566406-202.027344 201.886719-.015625 38.148437 10.65625 75.296875 30.875 107.445312l4.804688 7.640625-20.40625 74.5zm0 0\" fill=\"#fff\"/><path d=\"m19.34375 492.625 33.277344-121.519531c-20.53125-35.5625-31.324219-75.910157-31.3125-117.234375.050781-129.296875 105.273437-234.488282 234.558594-234.488282 62.75.027344 121.644531 24.449219 165.921874 68.773438 44.289063 44.324219 68.664063 103.242188 68.640626 165.898438-.054688 129.300781-105.28125 234.503906-234.550782 234.503906-.011718 0 .003906 0 0 0h-.105468c-39.253907-.015625-77.828126-9.867188-112.085938-28.539063zm0 0\" fill=\"#01e675\"/><g fill=\"#fff\"><path d=\"m10.894531 501.105469 34.46875-125.871094c-21.261719-36.839844-32.445312-78.628906-32.429687-121.441406.054687-133.933594 109.046875-242.898438 242.976562-242.898438 64.992188.027344 125.996094 25.324219 171.871094 71.238281 45.871094 45.914063 71.125 106.945313 71.101562 171.855469-.058593 133.929688-109.066406 242.910157-242.972656 242.910157-.007812 0 .003906 0 0 0h-.105468c-40.664063-.015626-80.617188-10.214844-116.105469-29.570313zm134.769531-77.75 7.378907 4.371093c31 18.398438 66.542969 28.128907 102.789062 28.148438h.078125c111.304688 0 201.898438-90.578125 201.945313-201.902344.019531-53.949218-20.964844-104.679687-59.09375-142.839844-38.132813-38.160156-88.832031-59.1875-142.777344-59.210937-111.394531 0-201.984375 90.566406-202.027344 201.886719-.015625 38.148437 10.65625 75.296875 30.875 107.445312l4.804688 7.640625-20.40625 74.5zm0 0\"/><path d=\"m195.183594 152.246094c-4.546875-10.109375-9.335938-10.3125-13.664063-10.488282-3.539062-.152343-7.589843-.144531-11.632812-.144531-4.046875 0-10.625 1.523438-16.1875 7.597657-5.566407 6.074218-21.253907 20.761718-21.253907 50.632812 0 29.875 21.757813 58.738281 24.792969 62.792969 3.035157 4.050781 42 67.308593 103.707031 91.644531 51.285157 20.226562 61.71875 16.203125 72.851563 15.191406 11.132813-1.011718 35.917969-14.6875 40.976563-28.863281 5.0625-14.175781 5.0625-26.324219 3.542968-28.867187-1.519531-2.527344-5.566406-4.046876-11.636718-7.082032-6.070313-3.035156-35.917969-17.726562-41.484376-19.75-5.566406-2.027344-9.613281-3.035156-13.660156 3.042969-4.050781 6.070313-15.675781 19.742187-19.21875 23.789063-3.542968 4.058593-7.085937 4.566406-13.15625 1.527343-6.070312-3.042969-25.625-9.449219-48.820312-30.132812-18.046875-16.089844-30.234375-35.964844-33.777344-42.042969-3.539062-6.070312-.058594-9.070312 2.667969-12.386719 4.910156-5.972656 13.148437-16.710937 15.171875-20.757812 2.023437-4.054688 1.011718-7.597657-.503906-10.636719-1.519532-3.035156-13.320313-33.058594-18.714844-45.066406zm0 0\" fill-rule=\"evenodd\"/></g></svg></a></div>
                </div>
                ";
        // line 205
        if (($context["open"] ?? null)) {
            // line 206
            echo "                <div class=\"mobile-job menu-info__item\">
                  <div class=\"title-information\">";
            // line 207
            echo ($context["text_job"] ?? null);
            echo "</div>
                  <div class=\"information-job\">";
            // line 208
            echo ($context["open"] ?? null);
            echo "</div>
                </div>
                ";
        }
        // line 211
        echo "                ";
        if ((twig_length_filter($this->env, ($context["currency"] ?? null)) > 1)) {
            // line 212
            echo "                <div class=\"mobile-currency menu-info__item\">
                  <div class=\"title-information\">";
            // line 213
            echo ($context["text_currency"] ?? null);
            echo "</div>
                </div>
                ";
        }
        // line 216
        echo "                ";
        if ((twig_length_filter($this->env, ($context["language"] ?? null)) > 1)) {
            // line 217
            echo "                <div class=\"mobile-language menu-info__item\">
                  <div class=\"title-information\">";
            // line 218
            echo ($context["text_language"] ?? null);
            echo "</div>
                </div>
                ";
        }
        // line 221
        echo "              </div>
            </div>
          </div>
          ";
        // line 224
        echo ($context["menu"] ?? null);
        echo "
          ";
        // line 225
        echo ($context["cart"] ?? null);
        echo "
          <div class=\"header-search__mobile slide-search hidden-md hidden-lg\">
            <div class=\"slide-header\">
              <span class=\"slide-title\">";
        // line 228
        echo ($context["text_search"] ?? null);
        echo "</span>
              <span class=\"slide-close\"><svg width=\"16\" height=\"16\" fill=\"#172033\" viewBox=\"0 0 16 16\" class=\"icon icon-close\"><path fill-rule=\"evenodd\" d=\"M2.293 2.293a1 1 0 011.414 0l10 10a1 1 0 01-1.414 1.414l-10-10a1 1 0 010-1.414z\" clip-rule=\"evenodd\"></path><path fill-rule=\"evenodd\" d=\"M13.707 2.293a1 1 0 00-1.414 0l-10 10a1 1 0 101.414 1.414l10-10a1 1 0 000-1.414z\" clip-rule=\"evenodd\"></path></svg></span>
            </div>
            <div class=\"header-search__mobile-control-container slide-search__content scroll-wrapper\">
              <div class=\"slide-search__content scroll-content\">
                <div class=\"search-control-mobile search-input\"></div>
              </div>
            </div>
          </div>
          <div class=\"menu-second-row hidden-xs\">
<div class=\"container\">
<div class=\"row\">
<div class=\"col-sm-12\">
<ul class=\"nav navbar-nav second-row-menu\">
<li><a href=\"/laminat/\"><span class=\"s-menu-name\">Ламинат</span></a></li>
<li><a href=\"/kvarcvinilovaya-plitka/\"><span class=\"s-menu-name\">Кварцвиниловый пол</span></a></li>
<li><a href=\"/inzhenernaya-doska/\"><span class=\"s-menu-name\">Инженерная доска</span></a></li>
<li><a href=\"/mezhkomnatnye-dveri/\"><span class=\"s-menu-name\">Межкомнатные двери</span></a></li>
<li><a href=\"/massivnaya-doska/\"><span class=\"s-menu-name\">Массивная доска</span></a></li>
<li><a href=\"/parketnaya-doska/\"><span class=\"s-menu-name\">Паркетная доска</span></a></li>
<li><a href=\"/furnitura/\"><span class=\"s-menu-name\">Фурнитура</span></a></li>
<li><a href=\"/plintus/\"><span class=\"s-menu-name\">Плинтуса</span></a></li>
<li><a href=\"/aksessuary/\"><span class=\"s-menu-name\">Аксессуары</span></a></li>

</ul>
</div>
</div>
</div>
</div>
          <div class=\"page-wrapper\">
            <div class=\"wrapper-middle\">";
    }

    public function getTemplateName()
    {
        return "stroimarket/template/common/header.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  571 => 228,  565 => 225,  561 => 224,  556 => 221,  550 => 218,  547 => 217,  544 => 216,  538 => 213,  535 => 212,  532 => 211,  526 => 208,  522 => 207,  519 => 206,  517 => 205,  507 => 201,  499 => 199,  497 => 198,  490 => 196,  486 => 195,  483 => 194,  477 => 190,  466 => 189,  462 => 188,  457 => 186,  454 => 185,  452 => 184,  445 => 180,  429 => 167,  425 => 166,  418 => 164,  409 => 158,  402 => 156,  392 => 149,  388 => 148,  381 => 146,  372 => 140,  368 => 139,  361 => 137,  353 => 132,  343 => 125,  334 => 118,  326 => 116,  323 => 115,  311 => 113,  301 => 111,  298 => 110,  296 => 109,  268 => 88,  259 => 82,  255 => 81,  250 => 78,  244 => 74,  233 => 73,  229 => 72,  226 => 71,  224 => 70,  214 => 62,  205 => 60,  200 => 59,  189 => 57,  185 => 56,  182 => 55,  173 => 53,  168 => 52,  155 => 50,  151 => 49,  136 => 38,  130 => 36,  124 => 34,  122 => 33,  118 => 32,  112 => 30,  106 => 28,  103 => 27,  97 => 25,  95 => 24,  90 => 23,  84 => 21,  81 => 20,  75 => 18,  73 => 17,  69 => 16,  58 => 10,  50 => 7,  42 => 4,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "stroimarket/template/common/header.twig", "");
    }
}
