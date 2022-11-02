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

/* stroimarket/template/common/footer.twig */
class __TwigTemplate_65bd113d24a1b4156640847e5865abc5f72688e45118d9a79ce87131dff89e08 extends \Twig\Template
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
        echo "    </div>
    <footer class=\"site-footer\">
      <div class=\"footer-container\">
        <div class=\"site-footer__inner\">
          <div class=\"container\">
            <div class=\"footer-column\">
              <div class=\"footer-column__block footer-column__list\">
                <div class=\"footer-column__list-item footer-column__information\">
                  <div class=\"footer-column__title\">Каталог</div>
                  <ul class=\"bottom-menu\">
                    <li><a href=\"/laminat\">Ламинат</a></li>
                    <li><a href=\"/parketnaya-doska\">Паркетная доска</a></li>
                    <li><a href=\"/kvarcvinilovaya-plitka\">Кварцвиниловый пол</a></li>
                    <li><a href=\"/massivnaya-doska\">Массивная доска</a></li>
                    <li><a href=\"/inzhenernaya-doska\">Инженерная доска</a></li>
                  </ul>
                </div>
                <div class=\"footer-column__list-item footer-column__service\">
                  <ul class=\"bottom-menu bottom-menu2child-footer\">
                    <li><a href=\"/mezhkomnatnye-dveri\">Межкомнатные двери</a></li>
                    <li><a href=\"/plintus\">Плинтус</a></li>
                    <li><a href=\"/aksessuary\">Аксессуары</a></li>
                  </ul>
                </div>
                <div class=\"footer-column__list-item footer-column__extra\">
                  <div class=\"footer-column__title\">";
        // line 26
        echo ($context["text_information"] ?? null);
        echo "</div>
                  <ul class=\"bottom-menu\">
                    ";
        // line 28
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["informations"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["information"]) {
            // line 29
            echo "                    <li><a href=\"";
            echo twig_get_attribute($this->env, $this->source, $context["information"], "href", [], "any", false, false, false, 29);
            echo "\">";
            echo twig_get_attribute($this->env, $this->source, $context["information"], "title", [], "any", false, false, false, 29);
            echo "</a></li>
                    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['information'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 31
        echo "                    <li><a href=\"";
        echo ($context["manufacturer"] ?? null);
        echo "\">";
        echo ($context["text_manufacturer"] ?? null);
        echo "</a></li>
                    <li><a href=\"";
        // line 32
        echo ($context["special"] ?? null);
        echo "\">";
        echo ($context["text_special"] ?? null);
        echo "</a></li>
                    <li><a href=\"";
        // line 33
        echo ($context["account"] ?? null);
        echo "\">";
        echo ($context["text_account"] ?? null);
        echo "</a></li>
                    <li><a href=\"";
        // line 34
        echo ($context["wishlist"] ?? null);
        echo "\">";
        echo ($context["text_wishlist"] ?? null);
        echo "</a></li>
                    <li><a href=\"";
        // line 35
        echo ($context["contact"] ?? null);
        echo "\">";
        echo ($context["text_contact"] ?? null);
        echo "</a></li>
                    <li><a href=\"";
        // line 36
        echo ($context["return"] ?? null);
        echo "\">";
        echo ($context["text_return"] ?? null);
        echo "</a></li>
                  </ul>
                </div>
                <div class=\"blocklogo-footer\">
                  <img src=\"/image/catalog/white-logo.png\" class=\"img-footer-logo\">
                  <div>Более 35 000 отделочных материалов в одном месте.</div>
                </div>
              </div>
              <div class=\"footer-column__block footer-column__contacts\">
                <div class=\"footer-column__phone-contacts\">
                  <div class=\"footer-column__title\">";
        // line 46
        echo ($context["text_contacts"] ?? null);
        echo "</div>
                  <div class=\"footer-column__phone column-contacts\">
                    <div class=\"icon-contacts phone-icon\">
                      <i class=\"fi fi-rr-phone-call\"></i>
                    </div>
                    <div class=\"phone-body\">
                      <div><a href=\"tel:";
        // line 52
        echo ($context["phone"] ?? null);
        echo "\">";
        echo ($context["telephone"] ?? null);
        echo "</a></div>
                      <a href=\"#callback\" class=\"callback callback-mobcolr\">Заказ звонка</a>
                    </div>
                  </div>
                  ";
        // line 56
        if (($context["config_footer_address"] ?? null)) {
            // line 57
            echo "                  ";
            if (($context["address"] ?? null)) {
                // line 58
                echo "                  <div class=\"footer-column__address column-contacts\">
                    <div class=\"icon-contacts address-icon\">
                      <i class=\"fi fi-rr-marker\"></i>
                    </div>
                    ";
                // line 62
                echo ($context["address"] ?? null);
                echo "
                  </div>
                  ";
            }
            // line 65
            echo "                  ";
        }
        // line 66
        echo "                  ";
        if (($context["config_footer_open"] ?? null)) {
            // line 67
            echo "                  ";
            if (($context["open"] ?? null)) {
                // line 68
                echo "                  <div class=\"footer-column__open column-contacts\">
                    <div class=\"icon-contacts open-icon\">
                      <i class=\"fi fi-rr-clock\"></i>
                    </div>
                    ";
                // line 72
                echo ($context["open"] ?? null);
                echo "
                  </div>
                  ";
            }
            // line 75
            echo "                  ";
        }
        // line 76
        echo "                  ";
        if (($context["config_footer_email"] ?? null)) {
            // line 77
            echo "                  ";
            if (($context["email"] ?? null)) {
                // line 78
                echo "                  <div class=\"footer-column__email column-contacts\">
                    <div class=\"icon-contacts email-icon\">
                      <i class=\"fi fi-rr-envelope\"></i>
                    </div>
                    ";
                // line 82
                echo ($context["email"] ?? null);
                echo "
                  </div>
                  ";
            }
            // line 85
            echo "                  ";
        }
        // line 86
        echo "                </div>
                <div class=\"footer-column__social\">
                  ";
        // line 88
        if (($context["social"] ?? null)) {
            // line 89
            echo "                  <div class=\"footer-column__title\">";
            echo ($context["text_social_title"] ?? null);
            echo "</div>
                  <div class=\"footer-column__social-item\">
                    ";
            // line 91
            if (($context["config_vkid"] ?? null)) {
                // line 92
                echo "                    <a href=\"";
                echo ($context["config_vkid"] ?? null);
                echo "\" class=\"config-vk ";
                if ( !($context["config_social_style"] ?? null)) {
                    echo "btn-rounded";
                }
                echo "\" rel=\"nofollow noopener\" target=\"_blank\" title=\"ВКонтакте\">
                      <span class=\"footer-social__icon\">
                        <svg width=\"22\" height=\"12\" viewBox=\"0 0 22 12\" xmlns=\"http://www.w3.org/2000/svg\">
                          <path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M21.8038 10.7034C22.5326 11.8582 20.9965 11.9491 20.9965 11.9491L18.0582 11.989C18.0582 11.989 17.4269 12.1079 16.5957 11.5625C15.4977 10.8412 14.4609 8.96619 13.6536 9.20994C12.8339 9.45968 12.8607 11.1469 12.8607 11.1469C12.8607 11.1469 12.8655 11.5065 12.6799 11.6983C12.4762 11.9071 12.0792 11.9491 12.0792 11.9491H10.7641C10.7641 11.9491 7.86306 12.1169 5.30734 9.57256C2.52111 6.79845 0.0591262 1.29318 0.0591262 1.29318C0.0591262 1.29318 -0.082431 0.932559 0.072519 0.757741C0.245642 0.561945 0.717187 0.548958 0.717187 0.548958L3.86018 0.528979C3.86018 0.528979 4.15669 0.57593 4.36808 0.724775C4.54311 0.847647 4.64163 1.07841 4.64163 1.07841C4.64163 1.07841 5.14952 2.30613 5.82288 3.41697C7.13613 5.58771 7.74732 6.06222 8.19304 5.82946C8.8425 5.49081 8.64833 2.76265 8.64833 2.76265C8.64833 2.76265 8.65981 1.77268 8.32121 1.33114C8.05818 0.990498 7.56368 0.889604 7.34465 0.861633C7.1677 0.838657 7.45847 0.447064 7.83436 0.271247C8.39964 0.0055241 9.39917 -0.0084614 10.5795 0.00252716C11.4986 0.0115178 11.7645 0.0664607 12.1232 0.148375C13.2069 0.399114 12.8396 1.36511 12.8396 3.68269C12.8396 4.42492 12.7 5.46884 13.2595 5.81547C13.5006 5.96332 14.0898 5.83745 15.5627 3.44594C16.261 2.31312 16.7842 0.97951 16.7842 0.97951C16.7842 0.97951 16.898 0.742757 17.0768 0.639864C17.2576 0.535972 17.5034 0.568937 17.5034 0.568937L20.8119 0.548958C20.8119 0.548958 21.8057 0.436076 21.9664 0.864629C22.1347 1.31516 21.5953 2.36607 20.2437 4.08827C18.0247 6.91633 17.777 6.6516 19.6201 8.2869C21.3801 9.84927 21.7445 10.6095 21.8038 10.7034Z\"></path>
                        </svg>
                      </span>
                    </a>
                    ";
            }
            // line 100
            echo "                    ";
            if (($context["config_telegramid"] ?? null)) {
                // line 101
                echo "                    <a href=\"";
                echo ($context["config_telegramid"] ?? null);
                echo "\" class=\"config-telegram ";
                if ( !($context["config_social_style"] ?? null)) {
                    echo "btn-rounded";
                }
                echo "\" rel=\"nofollow noopener\" target=\"_blank\" title=\"Telegram\">
                      <span class=\"footer-social__icon\">
                        <svg width=\"18\" height=\"18\" viewBox=\"0 0 32 32\" xmlns=\"http://www.w3.org/2000/svg\">
                          <path d=\"M29.919 6.163l-4.225 19.925c-0.319 1.406-1.15 1.756-2.331 1.094l-6.438-4.744-3.106 2.988c-0.344 0.344-0.631 0.631-1.294 0.631l0.463-6.556 11.931-10.781c0.519-0.462-0.113-0.719-0.806-0.256l-14.75 9.288-6.35-1.988c-1.381-0.431-1.406-1.381 0.288-2.044l24.837-9.569c1.15-0.431 2.156 0.256 1.781 2.013z\"/>
                        </svg>
                      </span>
                    </a>
                    ";
            }
            // line 109
            echo "                    ";
            if (($context["config_instagramid"] ?? null)) {
                // line 110
                echo "                    <a href=\"";
                echo ($context["config_instagramid"] ?? null);
                echo "\" class=\"config-instagram ";
                if ( !($context["config_social_style"] ?? null)) {
                    echo "btn-rounded";
                }
                echo "\" rel=\"nofollow noopener\" target=\"_blank\" title=\"Instagram\">
                      <span class=\"footer-social__icon\">
                        <svg width=\"20\" height=\"21\" viewBox=\"0 0 20 21\" xmlns=\"http://www.w3.org/2000/svg\">
                          <path fill-rule=\"evenodd\" clip-rule=\"evenodd\" d=\"M14.2257 21H5.77336C2.58451 21 0 18.2855 0 14.9363V6.06368C0 2.71543 2.58451 0 5.77336 0H14.2257C17.4146 0 20 2.71543 20 6.06368V14.9363C20 18.2855 17.4146 21 14.2257 21ZM18.1098 5.78784C18.1098 3.65749 16.4649 1.92992 14.4366 1.92992C14.4366 1.92992 12.3046 1.8192 10.219 1.8192C7.88258 1.8192 5.56345 1.92992 5.56345 1.92992C3.53419 1.92992 1.88932 3.65749 1.88932 5.78784C1.88932 5.78784 1.8366 8.2847 1.8366 10.6928C1.8366 12.9367 1.88932 15.1024 1.88932 15.1024C1.88932 17.2337 3.53419 18.9613 5.56345 18.9613C5.56345 18.9613 7.85805 19.071 10.1136 19.071C12.2928 19.071 14.4366 18.9613 14.4366 18.9613C16.4649 18.9613 18.1098 17.2337 18.1098 15.1024C18.1098 15.1024 18.2152 12.9367 18.2152 10.6928C18.2152 8.2847 18.1098 5.78784 18.1098 5.78784ZM15.3281 6.11808C14.661 6.11808 14.1203 5.55113 14.1203 4.85151C14.1203 4.15094 14.661 3.58399 15.3281 3.58399C15.9951 3.58399 16.5358 4.15094 16.5358 4.85151C16.5358 5.55113 15.9951 6.11808 15.3281 6.11808ZM9.99911 15.929C7.14378 15.929 4.82915 13.4989 4.82915 10.5C4.82915 7.50205 7.14378 5.07199 9.99911 5.07199C12.8553 5.07199 15.1699 7.50205 15.1699 10.5C15.1699 13.4989 12.8553 15.929 9.99911 15.929ZM9.99911 6.9456C8.15887 6.9456 6.66576 8.51282 6.66576 10.4446C6.66576 12.3784 8.15887 13.9456 9.99911 13.9456C11.8412 13.9456 13.3333 12.3784 13.3333 10.4446C13.3333 8.51282 11.8412 6.9456 9.99911 6.9456Z\"></path>
                        </svg>
                      </span>
                    </a>
                    ";
            }
            // line 118
            echo "                    ";
            if (($context["config_whatsappid"] ?? null)) {
                // line 119
                echo "                    <a href=\"";
                echo ($context["config_whatsappid"] ?? null);
                echo "\" class=\"config-whatsapp ";
                if ( !($context["config_social_style"] ?? null)) {
                    echo "btn-rounded";
                }
                echo "\" rel=\"nofollow noopener\" target=\"_blank\" title=\"Whatsapp\">
                      <span class=\"footer-social__icon\">
                        <svg width=\"24\" height=\"24\" viewBox=\"0 0 32 32\" xmlns=\"http://www.w3.org/2000/svg\"><path d=\" M19.11 17.205c-.372 0-1.088 1.39-1.518 1.39a.63.63 0 0 1-.315-.1c-.802-.402-1.504-.817-2.163-1.447-.545-.516-1.146-1.29-1.46-1.963a.426.426 0 0 1-.073-.215c0-.33.99-.945.99-1.49 0-.143-.73-2.09-.832-2.335-.143-.372-.214-.487-.6-.487-.187 0-.36-.043-.53-.043-.302 0-.53.115-.746.315-.688.645-1.032 1.318-1.06 2.264v.114c-.015.99.472 1.977 1.017 2.78 1.23 1.82 2.506 3.41 4.554 4.34.616.287 2.035.888 2.722.888.817 0 2.15-.515 2.478-1.318.13-.33.244-.73.244-1.088 0-.058 0-.144-.03-.215-.1-.172-2.434-1.39-2.678-1.39zm-2.908 7.593c-1.747 0-3.48-.53-4.942-1.49L7.793 24.41l1.132-3.337a8.955 8.955 0 0 1-1.72-5.272c0-4.955 4.04-8.995 8.997-8.995S25.2 10.845 25.2 15.8c0 4.958-4.04 8.998-8.998 8.998zm0-19.798c-5.96 0-10.8 4.842-10.8 10.8 0 1.964.53 3.898 1.546 5.574L5 27.176l5.974-1.92a10.807 10.807 0 0 0 16.03-9.455c0-5.958-4.842-10.8-10.802-10.8z\" fill-rule=\"evenodd\"></path></svg>
                      </span>
                    </a>
                    ";
            }
            // line 125
            echo "                  </div>
                  ";
        }
        // line 127
        echo "                  <!-- ";
        if (($context["config_payment_icon"] ?? null)) {
            // line 128
            echo "                  <div class=\"footer-column__payment\">
                    <div class=\"footer-column__title\">";
            // line 129
            echo ($context["text_accept_payment"] ?? null);
            echo "</div>
                    <img src=\"/image/payment/visa.png\" alt=\"Visa\">
                    <img src=\"/image/payment/mastercard.png\" alt=\"MasterCard\">
                    <img src=\"/image/payment/mir.png\" alt=\"МИР\">
                  </div>
                  ";
        }
        // line 134
        echo " -->
                </div>
              </div>
              <div class=\"footer-bottom\">
                <div class=\"footer-column__title\">";
        // line 138
        echo ($context["text_accept_payment"] ?? null);
        echo "</div>
                <div class=\"footer-bottom__powered\">
                  <img src=\"image/catalog/logo/paymethod.png\">
                </div>
              </div>
            </div>
            <div class=\"footerinfo-textsait\">
            <p class=\"powered-foot hidden-xs hidden-sm\">Copyright © polmetra.ru - All rights reserved. 2018-2022</p>
            <p class=\"hidden-xs hidden-sm\">Любая информация, представленная на данном сайте, носит исключительно информационный характер и ни при каких условиях не является публичной офертой, определяемой положениями статьи 437 ГК РФ.</p>
          </div>
        </div>
        </div>
      </div>
    </footer>
    ";
        // line 152
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["scripts"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["script"]) {
            // line 153
            echo "    <script src=\"";
            echo $context["script"];
            echo "\"></script>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['script'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 155
        echo "    </div>
    ";
        // line 156
        if (($context["top_button"] ?? null)) {
            // line 157
            echo "    <!-- Кнопка вверх -->
    <div class=\"scroll-fixed scroll-up\">
      <svg viewBox=\"0 0 8 11\" class=\"ToTopIcon\" width=\"8\" height=\"11\"><path d=\"M0 3.99h3V11h2V3.99h3L4 0 0 3.99z\"></path></svg>
    </div>
    ";
        }
        // line 162
        echo "    </div>

    <div class=\"hidden\">
<div class=\"container\">

<div id=\"callback\" class=\"callback-form product-popup\">

  <div class=\"formoneclickprod-title\">
    <h3>Заказать звонок</h3>
  </div>

  <div class=\"formoneclickprod-main\">
  <p>Введите номер телефона и наш менеджер перезвонит вам в течение <strong>15 минут</strong>.</p>
      
    <form id=\"forma-podpred1\" class=\"forma-qwest forms-sfloor-popu\">

                
                <!-- Hidden Required Fields -->
                <input type=\"hidden\" name=\"form_subject\" value=\"Форма - Заказ звонка (Polmetra.ru)\">
                <input type=\"hidden\" name=\"aurl\" value=\"";
        // line 181
        echo ($context["aurl"] ?? null);
        echo "\">
                <input type=\"hidden\" name=\"project_name\" value=\"Polmetra.ru\">
                <input type=\"hidden\" name=\"form_subject\" value=\"Заказ звонка (Polmetra.ru)\">
                <!-- END Hidden Required Fields -->
                <div class=\"forms-inputheadcall\">
                    <input type=\"text\" name=\"name\" class=\"chcksp\" placeholder=\"Ваше имя...\" maxlength=\"25\">
                    <input type=\"text\" name=\"text\" class=\"chcksp\" placeholder=\"Ваше имя...\" maxlength=\"25\">
                    <input type=\"text\" name=\"tname\" placeholder=\"Ваше имя...\" maxlength=\"25\">
                </div>
                <div class=\"forms-inputheadcall\">
                    <input class=\"phone_masckcom\" type=\"text\" name=\"Phone\" placeholder=\"Ваш телефон...\" required maxlength=\"25\">
                </div>
                <div>
                    <button class=\"popup-a-button-form button-formprod\">Отправить</button>
                </div>
            
              </form>

            </div>

    <div class=\"success\">Спасибо за заявку!</div>
  </div>

  </div>

</div>

<script>
  \$('.toclick, .callback').magnificPopup({
    mainClass: 'mfp-zoom-in',
    removalDelay: 400
  });

  //E-mail Ajax Send
  \$(document).ready(function() {
  \$(\"#forma-podpred1\").submit(function() {
    var th = \$(this);
    \$.ajax({
      type: \"POST\",
      url: \"mail.php\",
      data: th.serialize()
    }).done(function() {
      var pp_suc = th.closest('.product-popup').find('.success');
      pp_suc.fadeIn();
      setTimeout(function() {
        th.trigger(\"reset\");
        pp_suc.fadeOut();
        \$.magnificPopup.close();
      }, 2000);
    });
    return false;
  });
});
</script>
<!--<script src=\"//code-ya.jivosite.com/widget/zUiCGGwWRA\" async></script>-->



<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-170979335-1\"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-170979335-1');
</script>

<!-- Yandex.Metrika counter --> <script type=\"text/javascript\" > (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)}; m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)}) (window, document, \"script\", \"https://mc.yandex.ru/metrika/tag.js\", \"ym\"); ym(53688163, \"init\", { clickmap:true, trackLinks:true, accurateTrackBounce:true }); </script> <noscript><div><img src=\"https://mc.yandex.ru/watch/53688163\" style=\"position:absolute; left:-9999px;\" alt=\"\" /></div></noscript> <!-- /Yandex.Metrika counter -->
<script>
\t\$(document).ready(function(){
\t\t\$('.phone_masckcom').mask('+7(000)000-00-00');
\t});
</script>
  </body>
</html>";
    }

    public function getTemplateName()
    {
        return "stroimarket/template/common/footer.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  383 => 181,  362 => 162,  355 => 157,  353 => 156,  350 => 155,  341 => 153,  337 => 152,  320 => 138,  314 => 134,  305 => 129,  302 => 128,  299 => 127,  295 => 125,  281 => 119,  278 => 118,  262 => 110,  259 => 109,  243 => 101,  240 => 100,  224 => 92,  222 => 91,  216 => 89,  214 => 88,  210 => 86,  207 => 85,  201 => 82,  195 => 78,  192 => 77,  189 => 76,  186 => 75,  180 => 72,  174 => 68,  171 => 67,  168 => 66,  165 => 65,  159 => 62,  153 => 58,  150 => 57,  148 => 56,  139 => 52,  130 => 46,  115 => 36,  109 => 35,  103 => 34,  97 => 33,  91 => 32,  84 => 31,  73 => 29,  69 => 28,  64 => 26,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "stroimarket/template/common/footer.twig", "");
    }
}
