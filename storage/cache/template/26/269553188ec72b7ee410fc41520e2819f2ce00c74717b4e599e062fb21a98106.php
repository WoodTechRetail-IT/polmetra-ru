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

/* stroimarket/template/common/menu.twig */
class __TwigTemplate_5622a77c783ea00c2cdbcf9ad980fd906f2008b03d610ae65f73591b2789d03a extends \Twig\Template
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
        if (($context["categories"] ?? null)) {
            // line 2
            echo "<div class=\"header-nav__submenu header-submenu\">
  <div class=\"header-nav__container\">
    <div class=\"header-nav__submenu__content\">
      <div class=\"header-nav__catalog\">
        <div class=\"header-nav__catalog__menu\">
          <div class=\"header-submenu__col header-submenu__leftside header-submenu__col--grey\">
            <div class=\"header-submenu__parent\">
            
              <div class=\"header-submenu__title\">";
            // line 10
            echo ($context["text_catalog"] ?? null);
            echo "</div>
              <div class=\"header-nav__catalog__list\">
                <ul class=\"header-submenu__list\">
                  ";
            // line 13
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["categories"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
                // line 14
                echo "                  <li class=\"header-submenu__item\" data-id=\"";
                echo twig_get_attribute($this->env, $this->source, $context["category"], "category_id", [], "any", false, false, false, 14);
                echo "\">
                    <a href=\"";
                // line 15
                echo twig_get_attribute($this->env, $this->source, $context["category"], "href", [], "any", false, false, false, 15);
                echo "\" class=\"header-submenu__link category-link\">
                    ";
                // line 16
                if (twig_get_attribute($this->env, $this->source, $context["category"], "image", [], "any", false, false, false, 16)) {
                    // line 17
                    echo "                    <img src=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["category"], "image", [], "any", false, false, false, 17);
                    echo "\" alt=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 17);
                    echo "\">
                    ";
                }
                // line 19
                echo "                    <span>";
                echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 19);
                echo "</span>
                    </a>
                  </li>
                  ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 23
            echo "                </ul>
              </div>
            </div>
          </div>
          <div class=\"header-submenu__col header-submenu__rightside header-submenu__col--white\">
            <svg class=\"header-submenu__close\" xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 24 24\" fill=\"#5f6368\">
              <path d=\"M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z\"></path>
              <path fill=\"none\" d=\"M0 0h24v24H0z\"></path>
            </svg>
            
            ";
            // line 33
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["categories"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
                // line 34
                echo "            ";
                if (twig_get_attribute($this->env, $this->source, $context["category"], "children", [], "any", false, false, false, 34)) {
                    // line 35
                    echo "            <div class=\"header-submenu__block\" data-id=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["category"], "category_id", [], "any", false, false, false, 35);
                    echo "\">
              <div class=\"header-submenu__title\">";
                    // line 36
                    echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 36);
                    echo "</div>
              <div class=\"header-submenu__container\">
                ";
                    // line 38
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_array_batch(twig_get_attribute($this->env, $this->source, $context["category"], "children", [], "any", false, false, false, 38), twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, $context["category"], "children", [], "any", false, false, false, 38))));
                    foreach ($context['_seq'] as $context["_key"] => $context["children"]) {
                        // line 39
                        echo "                <div class=\"header-submenu__inner\">
                  ";
                        // line 40
                        $context['_parent'] = $context;
                        $context['_seq'] = twig_ensure_traversable($context["children"]);
                        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
                            // line 41
                            echo "                  ";
                            if (twig_get_attribute($this->env, $this->source, $context["child"], "gchildren", [], "any", false, false, false, 41)) {
                                // line 42
                                echo "                  <div class=\"header-submenu__column\">
                    <a href=\"";
                                // line 43
                                echo twig_get_attribute($this->env, $this->source, $context["child"], "href", [], "any", false, false, false, 43);
                                echo "\" class=\"submenu-link link-bold\">
                    ";
                                // line 44
                                if (twig_get_attribute($this->env, $this->source, $context["child"], "image", [], "any", false, false, false, 44)) {
                                    // line 45
                                    echo "                    <span class=\"header-submenu__image\"><img src=\"";
                                    echo twig_get_attribute($this->env, $this->source, $context["child"], "image", [], "any", false, false, false, 45);
                                    echo "\" alt=\"";
                                    echo twig_get_attribute($this->env, $this->source, $context["child"], "name", [], "any", false, false, false, 45);
                                    echo "\" title=\"";
                                    echo twig_get_attribute($this->env, $this->source, $context["child"], "name", [], "any", false, false, false, 45);
                                    echo "\" />";
                                    echo twig_get_attribute($this->env, $this->source, $context["child"], "stickersb", [], "any", false, false, false, 45);
                                    echo "</span>
                    ";
                                }
                                // line 47
                                echo "                    <span class=\"header-submenu__child\">";
                                echo twig_get_attribute($this->env, $this->source, $context["child"], "stickersb", [], "any", false, false, false, 47);
                                echo " ";
                                echo twig_get_attribute($this->env, $this->source, $context["child"], "name", [], "any", false, false, false, 47);
                                echo "</span>
                    </a>
                  </div>
                  ";
                            } else {
                                // line 51
                                echo "                  <div class=\"header-submenu__column\">
                    <a href=\"";
                                // line 52
                                echo twig_get_attribute($this->env, $this->source, $context["child"], "href", [], "any", false, false, false, 52);
                                echo "\" class=\"submenu-link link-bold\">
                    ";
                                // line 53
                                if (twig_get_attribute($this->env, $this->source, $context["child"], "image", [], "any", false, false, false, 53)) {
                                    // line 54
                                    echo "                    <span class=\"header-submenu__image\"><img src=\"";
                                    echo twig_get_attribute($this->env, $this->source, $context["child"], "image", [], "any", false, false, false, 54);
                                    echo "\" alt=\"";
                                    echo twig_get_attribute($this->env, $this->source, $context["child"], "name", [], "any", false, false, false, 54);
                                    echo "\" title=\"";
                                    echo twig_get_attribute($this->env, $this->source, $context["child"], "name", [], "any", false, false, false, 54);
                                    echo "\" />";
                                    echo twig_get_attribute($this->env, $this->source, $context["child"], "stickersb", [], "any", false, false, false, 54);
                                    echo "</span>
                    ";
                                }
                                // line 56
                                echo "                    <span class=\"header-submenu__child\">";
                                echo twig_get_attribute($this->env, $this->source, $context["child"], "stickersb", [], "any", false, false, false, 56);
                                echo " ";
                                echo twig_get_attribute($this->env, $this->source, $context["child"], "name", [], "any", false, false, false, 56);
                                echo "</span>
                    </a>
                  </div>
                  ";
                            }
                            // line 60
                            echo "                  
                  
                  
                  ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 64
                        echo "                </div>
                
                ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['children'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 67
                    echo "                
              </div>
              
                    ";
                    // line 70
                    if (twig_get_attribute($this->env, $this->source, $context["category"], "menudopblock", [], "any", false, false, false, 70)) {
                        // line 71
                        echo "                    <!--<div class=\"header-submenu__title\">Подбор по характеристикам</div>-->
                    <div class=\"header-submenu__container\">
                        <div class=\"header-submenu__inner\">
                            ";
                        // line 74
                        echo twig_get_attribute($this->env, $this->source, $context["category"], "menudopblock", [], "any", false, false, false, 74);
                        echo "
                        </div>
                      </div>
                    ";
                    }
                    // line 78
                    echo "            </div>
            ";
                }
                // line 80
                echo "            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 81
            echo "            
            
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class=\"mobile-catalog catalog-category\">
  <div class=\"mobile-catalog__panel\">
    <div class=\"mobile-catalog__push\">
      <div class=\"FxW4\"></div>
    </div>
    <div class=\"mobile-catalog__title\">";
            // line 95
            echo ($context["text_catalog"] ?? null);
            echo "</div>
    <button type=\"button\" aria-label=\"Закрыть каталог\" class=\"clear-button mobile-catalog__close\">
      <svg width=\"16\" height=\"16\" fill=\"#172033\" viewBox=\"0 0 16 16\" class=\"icon icon-close\">
        <path fill-rule=\"evenodd\" d=\"M2.293 2.293a1 1 0 011.414 0l10 10a1 1 0 01-1.414 1.414l-10-10a1 1 0 010-1.414z\" clip-rule=\"evenodd\"></path>
        <path fill-rule=\"evenodd\" d=\"M13.707 2.293a1 1 0 00-1.414 0l-10 10a1 1 0 101.414 1.414l10-10a1 1 0 000-1.414z\" clip-rule=\"evenodd\"></path>
      </svg>
    </button>
  </div>
  <div class=\"mobile-catalog__inner\">
    <ul class=\"mobile-catalog__list\">
      ";
            // line 105
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["categories"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
                // line 106
                echo "      ";
                if (twig_get_attribute($this->env, $this->source, $context["category"], "children", [], "any", false, false, false, 106)) {
                    // line 107
                    echo "      <li class=\"mobile-catalog__item has-item\">
        <div class=\"mobile-item\">
          ";
                    // line 109
                    if (twig_get_attribute($this->env, $this->source, $context["category"], "image", [], "any", false, false, false, 109)) {
                        // line 110
                        echo "          <div class=\"kMP8 mobile-catalog__image\">
            <img src=\"";
                        // line 111
                        echo twig_get_attribute($this->env, $this->source, $context["category"], "image", [], "any", false, false, false, 111);
                        echo "\" alt=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 111);
                        echo "\" class=\"mobile-catalog__img\">
          </div>
          ";
                    }
                    // line 114
                    echo "          <div class=\"mobile-catalog__name\">";
                    echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 114);
                    echo "</div>
          <div class=\"ULo6 mobile-catalog__icon__arrow d-flex\">
            <svg width=\"16\" height=\"16\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\" class=\"icon icon-arrow\">
              <path d=\"M5.293 12.293a1 1 0 101.414 1.414l5-5a1 1 0 000-1.414l-5-5a1 1 0 00-1.414 1.414L9.586 8l-4.293 4.293z\" fill=\"currentColor\"></path>
            </svg>
          </div>
        </div>
        <div class=\"mobile-catalog catalog-children\">
          <div class=\"mobile-catalog__panel\">
            <button type=\"button\" aria-label=\"Вернуться назад\" class=\"clear-button mobile-catalog__back\">
              <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" fill=\"currentColor\" class=\"icon icon-arrow-left\" viewBox=\"0 0 16 16\">
                <path fill-rule=\"evenodd\" d=\"M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z\"/>
              </svg>
            </button>
            <div class=\"mobile-catalog__title\">";
                    // line 128
                    echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 128);
                    echo "</div>
            <button type=\"button\" aria-label=\"Закрыть каталог\" class=\"clear-button mobile-catalog__close\">
              <svg width=\"16\" height=\"16\" fill=\"#172033\" viewBox=\"0 0 16 16\" class=\"icon icon-close\">
                <path fill-rule=\"evenodd\" d=\"M2.293 2.293a1 1 0 011.414 0l10 10a1 1 0 01-1.414 1.414l-10-10a1 1 0 010-1.414z\" clip-rule=\"evenodd\"></path>
                <path fill-rule=\"evenodd\" d=\"M13.707 2.293a1 1 0 00-1.414 0l-10 10a1 1 0 101.414 1.414l10-10a1 1 0 000-1.414z\" clip-rule=\"evenodd\"></path>
              </svg>
            </button>
          </div>
          <div class=\"mobile-catalog__inner\">
            ";
                    // line 137
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_array_batch(twig_get_attribute($this->env, $this->source, $context["category"], "children", [], "any", false, false, false, 137), twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, $context["category"], "children", [], "any", false, false, false, 137))));
                    foreach ($context['_seq'] as $context["_key"] => $context["children"]) {
                        // line 138
                        echo "            <ul class=\"mobile-catalog__list\">
              <li class=\"mobile-catalog__item mobile-catalog__all\">
                <span class=\"mobile-item mobile-catalog__link\" data-link=\"";
                        // line 140
                        echo twig_get_attribute($this->env, $this->source, $context["category"], "href", [], "any", false, false, false, 140);
                        echo "\">
                  <span class=\"mobile-catalog__name\">";
                        // line 141
                        echo ($context["text_see_all_products"] ?? null);
                        echo "</span>
                </span>
              </li>
              ";
                        // line 144
                        $context['_parent'] = $context;
                        $context['_seq'] = twig_ensure_traversable($context["children"]);
                        foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
                            // line 145
                            echo "              ";
                            if (twig_get_attribute($this->env, $this->source, $context["child"], "gchildren", [], "any", false, false, false, 145)) {
                                // line 146
                                echo "              <li class=\"mobile-catalog__item has-item\">
                <span class=\"mobile-item\">
                  <span class=\"mobile-catalog__name\">";
                                // line 148
                                echo twig_get_attribute($this->env, $this->source, $context["child"], "name", [], "any", false, false, false, 148);
                                echo "</span>
                  <span class=\"mobile-catalog__icon__arrow d-flex\">
                    <svg width=\"16\" height=\"16\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\" class=\"icon icon-arrow\">
                      <path d=\"M5.293 12.293a1 1 0 101.414 1.414l5-5a1 1 0 000-1.414l-5-5a1 1 0 00-1.414 1.414L9.586 8l-4.293 4.293z\" fill=\"currentColor\"></path>
                    </svg>
                  </span>
                </span>
                <div class=\"mobile-catalog catalog-child\">
                  <div class=\"mobile-catalog__panel\">
                    <button type=\"button\" aria-label=\"Вернуться назад\" class=\"clear-button mobile-catalog__back\">
                      <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"20\" height=\"20\" fill=\"currentColor\" class=\"icon icon-arrow-left\" viewBox=\"0 0 16 16\">
                        <path fill-rule=\"evenodd\" d=\"M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z\"/>
                      </svg>
                    </button>
                    <div class=\"mobile-catalog__title\">";
                                // line 162
                                echo twig_get_attribute($this->env, $this->source, $context["child"], "name", [], "any", false, false, false, 162);
                                echo "</div>
                    <button type=\"button\" aria-label=\"Закрыть каталог\" class=\"clear-button mobile-catalog__close\">
                      <svg width=\"16\" height=\"16\" fill=\"#172033\" viewBox=\"0 0 16 16\" class=\"icon icon-close\">
                        <path fill-rule=\"evenodd\" d=\"M2.293 2.293a1 1 0 011.414 0l10 10a1 1 0 01-1.414 1.414l-10-10a1 1 0 010-1.414z\" clip-rule=\"evenodd\"></path>
                        <path fill-rule=\"evenodd\" d=\"M13.707 2.293a1 1 0 00-1.414 0l-10 10a1 1 0 101.414 1.414l10-10a1 1 0 000-1.414z\" clip-rule=\"evenodd\"></path>
                      </svg>
                    </button>
                  </div>
                  <div class=\"mobile-catalog__inner\">
                    <ul class=\"mobile-catalog__list\">
                      <li class=\"mobile-catalog__item mobile-catalog__all\">
                        <span class=\"mobile-item mobile-catalog__link\" data-link=\"";
                                // line 173
                                echo twig_get_attribute($this->env, $this->source, $context["child"], "href", [], "any", false, false, false, 173);
                                echo "\">
                          <span class=\"mobile-catalog__name\">";
                                // line 174
                                echo ($context["text_see_all_products"] ?? null);
                                echo "</span>
                        </span>
                      </li>
                      ";
                                // line 177
                                $context['_parent'] = $context;
                                $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["child"], "gchildren", [], "any", false, false, false, 177));
                                foreach ($context['_seq'] as $context["_key"] => $context["gchild"]) {
                                    echo "\t\t      
                      <li class=\"mobile-catalog__item\">
                        <span class=\"mobile-item mobile-catalog__link\" data-link=\"";
                                    // line 179
                                    echo twig_get_attribute($this->env, $this->source, $context["gchild"], "href", [], "any", false, false, false, 179);
                                    echo "\">
                        <span class=\"mobile-catalog__name\">";
                                    // line 180
                                    echo twig_get_attribute($this->env, $this->source, $context["gchild"], "name", [], "any", false, false, false, 180);
                                    echo "  ";
                                    echo twig_get_attribute($this->env, $this->source, $context["child"], "count", [], "any", false, false, false, 180);
                                    echo "</span>
                        </span>
                      </li>
                      ";
                                }
                                $_parent = $context['_parent'];
                                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['gchild'], $context['_parent'], $context['loop']);
                                $context = array_intersect_key($context, $_parent) + $_parent;
                                // line 184
                                echo "                    </ul>
                  </div>
                </div>
              </li>
              ";
                            } else {
                                // line 189
                                echo "              <li class=\"mobile-catalog__item\">
                <span class=\"mobile-item mobile-catalog__link\" data-link=\"";
                                // line 190
                                echo twig_get_attribute($this->env, $this->source, $context["child"], "href", [], "any", false, false, false, 190);
                                echo "\">
                  <span class=\"mobile-catalog__name\">";
                                // line 191
                                echo twig_get_attribute($this->env, $this->source, $context["child"], "name", [], "any", false, false, false, 191);
                                echo "</span>
                </span>
              </li>
              ";
                            }
                            // line 195
                            echo "              ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 196
                        echo "            </ul>
            ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['children'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 198
                    echo "          </div>
        </div>
      </li>
      ";
                } else {
                    // line 202
                    echo "      <li class=\"mobile-catalog__item\">
        <div class=\"mobile-item mobile-catalog__link\" data-link=\"";
                    // line 203
                    echo twig_get_attribute($this->env, $this->source, $context["category"], "href", [], "any", false, false, false, 203);
                    echo "\">
          ";
                    // line 204
                    if (twig_get_attribute($this->env, $this->source, $context["category"], "image", [], "any", false, false, false, 204)) {
                        // line 205
                        echo "          <div class=\"mobile-catalog__image\">
            <img src=\"";
                        // line 206
                        echo twig_get_attribute($this->env, $this->source, $context["category"], "image", [], "any", false, false, false, 206);
                        echo "\" alt=\"";
                        echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 206);
                        echo "\" class=\"mobile-catalog__img\">
          </div>
          ";
                    }
                    // line 209
                    echo "          <div class=\"mobile-catalog__name\">";
                    echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 209);
                    echo " ";
                    echo twig_get_attribute($this->env, $this->source, ($context["child"] ?? null), "count", [], "any", false, false, false, 209);
                    echo "</div>
        </div>
      </li>
      ";
                }
                // line 213
                echo "      ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 214
            echo "    </ul>
  </div>
</div>
";
        }
    }

    public function getTemplateName()
    {
        return "stroimarket/template/common/menu.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  492 => 214,  486 => 213,  476 => 209,  468 => 206,  465 => 205,  463 => 204,  459 => 203,  456 => 202,  450 => 198,  443 => 196,  437 => 195,  430 => 191,  426 => 190,  423 => 189,  416 => 184,  404 => 180,  400 => 179,  393 => 177,  387 => 174,  383 => 173,  369 => 162,  352 => 148,  348 => 146,  345 => 145,  341 => 144,  335 => 141,  331 => 140,  327 => 138,  323 => 137,  311 => 128,  293 => 114,  285 => 111,  282 => 110,  280 => 109,  276 => 107,  273 => 106,  269 => 105,  256 => 95,  240 => 81,  234 => 80,  230 => 78,  223 => 74,  218 => 71,  216 => 70,  211 => 67,  203 => 64,  194 => 60,  184 => 56,  172 => 54,  170 => 53,  166 => 52,  163 => 51,  153 => 47,  141 => 45,  139 => 44,  135 => 43,  132 => 42,  129 => 41,  125 => 40,  122 => 39,  118 => 38,  113 => 36,  108 => 35,  105 => 34,  101 => 33,  89 => 23,  78 => 19,  70 => 17,  68 => 16,  64 => 15,  59 => 14,  55 => 13,  49 => 10,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "stroimarket/template/common/menu.twig", "");
    }
}
