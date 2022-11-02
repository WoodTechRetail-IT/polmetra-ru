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

/* default/template/extension/module/ldev_question/ldev_question_collapse.twig */
class __TwigTemplate_8021070c885ca0f2ed6636f10ca5abe650f21e2a7d180988f0c4a608e90712d3 extends \Twig\Template
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
        echo "<div
        role=\"tablist\" aria-multiselectable=\"true\" id=\"accordion-";
        // line 2
        echo ($context["item_id"] ?? null);
        echo "\" class=\"panel-group accordion\">

    ";
        // line 4
        if (($context["heading_status"] ?? null)) {
            echo " <h4>";
            echo ($context["name"] ?? null);
            echo "</h4> ";
        }
        // line 5
        echo "    ";
        echo ($context["about"] ?? null);
        echo "
    ";
        // line 6
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["list"] ?? null));
        foreach ($context['_seq'] as $context["k"] => $context["question"]) {
            // line 7
            echo "    <div

            class=\"panel panel-default card\">
        <a class=\"panel-heading card-header ";
            // line 10
            if ((($context["collapse_activate_1st"] ?? null) && ($context["k"] == 0))) {
                echo " collapsed ";
            }
            echo "\"
           data-toggle=\"collapse\"
            href=\"#collapse-";
            // line 12
            echo ((($context["item_id"] ?? null) . "-") . $context["k"]);
            echo " \"
            aria-controls=\"#collapse-";
            // line 13
            echo ((($context["item_id"] ?? null) . "-") . $context["k"]);
            echo " \"
        >
            <h4 class=\"panel-title mb-0\">
                <span class=\"accordion-item-icon\">";
            // line 16
            echo twig_get_attribute($this->env, $this->source, $context["question"], "marker", [], "any", false, false, false, 16);
            echo "</span>
                ";
            // line 17
            echo twig_get_attribute($this->env, $this->source, $context["question"], "title", [], "any", false, false, false, 17);
            echo "
            </h4>
        </a>
        <div id=\"collapse-";
            // line 20
            echo ((($context["item_id"] ?? null) . "-") . $context["k"]);
            echo "\" class=\"panel-collapse collapse ";
            if ((($context["collapse_activate_1st"] ?? null) && ($context["k"] == 0))) {
                echo " in ";
            }
            echo "\"
                ";
            // line 21
            if (($context["hide_sublings"] ?? null)) {
                // line 22
                echo "                    data-parent=\"#accordion-";
                echo ($context["item_id"] ?? null);
                echo "\"
                ";
            }
            // line 24
            echo "        >
            <div class=\"panel-body card-body\">
                ";
            // line 26
            if (twig_get_attribute($this->env, $this->source, $context["question"], "thumb", [], "any", false, false, false, 26)) {
                // line 27
                echo "                    ";
                if (twig_get_attribute($this->env, $this->source, $context["question"], "link", [], "any", false, false, false, 27)) {
                    // line 28
                    echo "                        <a href=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["question"], "link", [], "any", false, false, false, 28);
                    echo "\"><img src=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["question"], "thumb", [], "any", false, false, false, 28);
                    echo "\" alt=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["question"], "title", [], "any", false, false, false, 28);
                    echo "\" title=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["question"], "title", [], "any", false, false, false, 28);
                    echo "\"></a>
                    ";
                } else {
                    // line 30
                    echo "                        <img src=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["question"], "thumb", [], "any", false, false, false, 30);
                    echo "\" alt=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["question"], "title", [], "any", false, false, false, 30);
                    echo "\" title=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["question"], "title", [], "any", false, false, false, 30);
                    echo "\">
                    ";
                }
                // line 32
                echo "                ";
            }
            // line 33
            echo "                <div>";
            echo twig_get_attribute($this->env, $this->source, $context["question"], "text", [], "any", false, false, false, 33);
            echo "</div>
                <div>";
            // line 34
            echo twig_get_attribute($this->env, $this->source, $context["question"], "module", [], "any", false, false, false, 34);
            echo "</div>
            </div>
        </div>

    </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['k'], $context['question'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 40
        echo "</div>



";
    }

    public function getTemplateName()
    {
        return "default/template/extension/module/ldev_question/ldev_question_collapse.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  159 => 40,  147 => 34,  142 => 33,  139 => 32,  129 => 30,  117 => 28,  114 => 27,  112 => 26,  108 => 24,  102 => 22,  100 => 21,  92 => 20,  86 => 17,  82 => 16,  76 => 13,  72 => 12,  65 => 10,  60 => 7,  56 => 6,  51 => 5,  45 => 4,  40 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "default/template/extension/module/ldev_question/ldev_question_collapse.twig", "");
    }
}
