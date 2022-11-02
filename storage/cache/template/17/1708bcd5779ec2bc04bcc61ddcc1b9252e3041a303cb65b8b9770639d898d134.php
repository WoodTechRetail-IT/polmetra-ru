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

/* stroimarket/template/product/review.twig */
class __TwigTemplate_50e8898e89905e71bdb133444155c6b4b95b4bc394eaa091662382b25e150c0d extends \Twig\Template
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
        if (($context["reviews"] ?? null)) {
            // line 2
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(($context["reviews"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["review"]) {
                // line 3
                echo "<div class=\"review-table\">
  <div class=\"review-table__author\">
    <div class=\"review-author\"><strong>";
                // line 5
                echo twig_get_attribute($this->env, $this->source, $context["review"], "author", [], "any", false, false, false, 5);
                echo "</strong></div>
    <div class=\"review-rating rating\">
      ";
                // line 7
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(range(1, 5));
                foreach ($context['_seq'] as $context["_key"] => $context["i"]) {
                    // line 8
                    echo "      ";
                    if ((twig_get_attribute($this->env, $this->source, $context["review"], "rating", [], "any", false, false, false, 8) < $context["i"])) {
                        // line 9
                        echo "      <span class=\"star-empty\"><i class=\"fa fa-star\"></i></span>
      ";
                    } else {
                        // line 11
                        echo "      <span class=\"star\"><i class=\"fa fa-star\"></i></span>
      ";
                    }
                    // line 13
                    echo "      ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['i'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 14
                echo "    </div>
    <div class=\"review-date\">";
                // line 15
                echo twig_get_attribute($this->env, $this->source, $context["review"], "date_added", [], "any", false, false, false, 15);
                echo "</div>
    <div class=\"review-text\"><p>";
                // line 16
                echo twig_get_attribute($this->env, $this->source, $context["review"], "text", [], "any", false, false, false, 16);
                echo "</p></div>
  </div>
</div>
";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['review'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 20
            echo "<div class=\"text-right\">";
            echo ($context["pagination"] ?? null);
            echo "</div>
";
        } else {
            // line 22
            echo "<p>";
            echo ($context["text_no_reviews"] ?? null);
            echo "</p>
";
        }
    }

    public function getTemplateName()
    {
        return "stroimarket/template/product/review.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  96 => 22,  90 => 20,  80 => 16,  76 => 15,  73 => 14,  67 => 13,  63 => 11,  59 => 9,  56 => 8,  52 => 7,  47 => 5,  43 => 3,  39 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "stroimarket/template/product/review.twig", "");
    }
}
