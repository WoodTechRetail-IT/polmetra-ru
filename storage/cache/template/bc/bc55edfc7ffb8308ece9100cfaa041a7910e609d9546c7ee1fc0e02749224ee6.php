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

/* stroimarket/template/common/cart.twig */
class __TwigTemplate_86480a66663fdd7015bc1556039f194012e0c539cba768ac7770692a80eb284a extends \Twig\Template
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
        echo "<div id=\"mini-cart\">
  <div class=\"cart-panel\">
    ";
        // line 3
        if ((($context["products"] ?? null) || ($context["vouchers"] ?? null))) {
            // line 4
            echo "\t<div class=\"mini has-scrollbar has-top__menu\">
\t  <div class=\"mini-content\">\t    
\t\t<ul class=\"mini-list\">\t\t  
\t\t  ";
            // line 7
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["products"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["product"]) {
                // line 8
                echo "\t\t  <li>
\t\t    <i class=\"delete\" onclick=\"cart.remove('";
                // line 9
                echo twig_get_attribute($this->env, $this->source, $context["product"], "cart_id", [], "any", false, false, false, 9);
                echo "');\" title=\"";
                echo ($context["button_remove"] ?? null);
                echo "\" class=\"fa fa-times-circle\"></i>
\t\t\t";
                // line 10
                if (twig_get_attribute($this->env, $this->source, $context["product"], "thumb", [], "any", false, false, false, 10)) {
                    // line 11
                    echo "\t\t\t<div class=\"minicart-img\">
\t\t\t  <img src=\"";
                    // line 12
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "thumb", [], "any", false, false, false, 12);
                    echo "\" alt=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 12);
                    echo "\" title=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 12);
                    echo "\" class=\"img-responsive\" />
\t\t\t</div>
\t\t\t";
                }
                // line 15
                echo "\t\t\t<div class=\"minicart-info\">
\t\t\t  ";
                // line 16
                if (twig_get_attribute($this->env, $this->source, $context["product"], "sku", [], "any", false, false, false, 16)) {
                    // line 17
                    echo "\t\t\t  <p class=\"minicart-article\">";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "sku", [], "any", false, false, false, 17);
                    echo "</p>
\t\t\t  ";
                }
                // line 19
                echo "\t\t\t  <h4 class=\"minicart-name\">";
                echo twig_get_attribute($this->env, $this->source, $context["product"], "name", [], "any", false, false, false, 19);
                echo "</h4>
\t\t\t  ";
                // line 20
                if (twig_get_attribute($this->env, $this->source, $context["product"], "option", [], "any", false, false, false, 20)) {
                    // line 21
                    echo "\t\t\t  ";
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["product"], "option", [], "any", false, false, false, 21));
                    foreach ($context['_seq'] as $context["_key"] => $context["option"]) {
                        // line 22
                        echo "\t\t\t  - <small>";
                        echo twig_get_attribute($this->env, $this->source, $context["option"], "name", [], "any", false, false, false, 22);
                        echo " ";
                        echo twig_get_attribute($this->env, $this->source, $context["option"], "value", [], "any", false, false, false, 22);
                        echo "</small>
\t\t\t  ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['option'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 23
                    echo "\t\t\t
\t\t\t  ";
                }
                // line 25
                echo "\t\t\t  ";
                if (twig_get_attribute($this->env, $this->source, $context["product"], "recurring", [], "any", false, false, false, 25)) {
                    // line 26
                    echo "\t\t\t  - <small>";
                    echo ($context["text_recurring"] ?? null);
                    echo " ";
                    echo twig_get_attribute($this->env, $this->source, $context["product"], "recurring", [], "any", false, false, false, 26);
                    echo "</small>
\t\t\t  ";
                }
                // line 28
                echo "\t\t\t</div>
\t\t\t<div class=\"minicart-price\">
\t\t\t  <p>";
                // line 30
                echo twig_get_attribute($this->env, $this->source, $context["product"], "total", [], "any", false, false, false, 30);
                echo "</p>
\t\t\t  <div class=\"minicart-quantity\">";
                // line 31
                echo twig_get_attribute($this->env, $this->source, $context["product"], "quantity", [], "any", false, false, false, 31);
                echo " шт</div>
\t\t\t</div>
\t\t  </li>
          ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['product'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 34
            echo "\t\t  
\t\t</ul>\t\t
\t  </div>\t
\t</div>
\t<div class=\"minicart-total\">
\t  <div class=\"minicart-totals\">
\t    ";
            // line 40
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["totals"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["total"]) {
                // line 41
                echo "\t\t<div class=\"minicart-totals__container\">
\t      <div class=\"minicart-summ minicart-title\">";
                // line 42
                echo twig_get_attribute($this->env, $this->source, $context["total"], "title", [], "any", false, false, false, 42);
                echo "</div>
          <div class=\"minicart-summ minicart-text\">";
                // line 43
                echo twig_get_attribute($this->env, $this->source, $context["total"], "text", [], "any", false, false, false, 43);
                echo "</div>
\t\t</div>
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['total'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 46
            echo "\t  </div>
\t  <a href=\"";
            // line 47
            echo ($context["checkout"] ?? null);
            echo "\" class=\"btn btn-primary minicart-button\">";
            echo ($context["text_checkout"] ?? null);
            echo "</a>
    </div>
\t";
        } else {
            // line 50
            echo "    <div class=\"minicart-empty empty-message\">";
            echo ($context["text_empty"] ?? null);
            echo "</div>
\t";
        }
        // line 52
        echo "\t<a href=\"index.php?route=checkout/cartprint\" target=\"_blank\" class=\"btn btn-primary btn-block\"><i class=\"fa fa-print\"></i> ";
        echo ($context["text_print"] ?? null);
        echo "</a>
  </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "stroimarket/template/common/cart.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  188 => 52,  182 => 50,  174 => 47,  171 => 46,  162 => 43,  158 => 42,  155 => 41,  151 => 40,  143 => 34,  133 => 31,  129 => 30,  125 => 28,  117 => 26,  114 => 25,  110 => 23,  99 => 22,  94 => 21,  92 => 20,  87 => 19,  81 => 17,  79 => 16,  76 => 15,  66 => 12,  63 => 11,  61 => 10,  55 => 9,  52 => 8,  48 => 7,  43 => 4,  41 => 3,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "stroimarket/template/common/cart.twig", "");
    }
}
