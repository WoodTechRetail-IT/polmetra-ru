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

/* stroimarket/template/extension/module/category.twig */
class __TwigTemplate_b9851be2df1b0e72333343bf3808e912023a012784285040f94c3946d3c9d44e extends \Twig\Template
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
        echo "<div class=\"category-module\">
  <div class=\"title-module\">Категории</div>
  <ul class=\"list-unstyled\">
\t";
        // line 4
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["categories"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["category"]) {
            // line 5
            echo "    ";
            if (twig_get_attribute($this->env, $this->source, $context["category"], "category_id", [], "any", false, false, false, 5)) {
                echo " 
    <li><a href=\"";
                // line 6
                echo twig_get_attribute($this->env, $this->source, $context["category"], "href", [], "any", false, false, false, 6);
                echo "\" class=\"list-module-item active\">";
                echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 6);
                echo "</a>
      ";
                // line 7
                if (twig_get_attribute($this->env, $this->source, $context["category"], "children", [], "any", false, false, false, 7)) {
                    // line 8
                    echo "      <ul class=\"list-unstyled list-child\">
\t\t";
                    // line 9
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["category"], "children", [], "any", false, false, false, 9));
                    foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
                        echo "\t  
\t\t";
                        // line 10
                        if ((twig_get_attribute($this->env, $this->source, $context["child"], "category_id", [], "any", false, false, false, 10) == ($context["child_id"] ?? null))) {
                            // line 11
                            echo "        <li><a href=\"";
                            echo twig_get_attribute($this->env, $this->source, $context["child"], "href", [], "any", false, false, false, 11);
                            echo "\" class=\"list-module-item active\">";
                            echo twig_get_attribute($this->env, $this->source, $context["child"], "name", [], "any", false, false, false, 11);
                            echo "</a></li>
        ";
                        } else {
                            // line 12
                            echo " 
        <li><a href=\"";
                            // line 13
                            echo twig_get_attribute($this->env, $this->source, $context["child"], "href", [], "any", false, false, false, 13);
                            echo "\" class=\"list-module-item\">";
                            echo twig_get_attribute($this->env, $this->source, $context["child"], "name", [], "any", false, false, false, 13);
                            echo "</a></li>      
\t    ";
                        }
                        // line 15
                        echo "\t\t";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['child'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 16
                    echo "      </ul>\t
\t  ";
                }
                // line 17
                echo "\t
    </li>\t
\t";
            } else {
                // line 20
                echo "\t<li><a href=\"";
                echo twig_get_attribute($this->env, $this->source, $context["category"], "href", [], "any", false, false, false, 20);
                echo "\" class=\"list-module-item\">";
                echo twig_get_attribute($this->env, $this->source, $context["category"], "name", [], "any", false, false, false, 20);
                echo "</a></li>
    ";
            }
            // line 22
            echo "    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['category'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 23
        echo "  </ul>
</div>
";
    }

    public function getTemplateName()
    {
        return "stroimarket/template/extension/module/category.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  117 => 23,  111 => 22,  103 => 20,  98 => 17,  94 => 16,  88 => 15,  81 => 13,  78 => 12,  70 => 11,  68 => 10,  62 => 9,  59 => 8,  57 => 7,  51 => 6,  46 => 5,  42 => 4,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "stroimarket/template/extension/module/category.twig", "");
    }
}
