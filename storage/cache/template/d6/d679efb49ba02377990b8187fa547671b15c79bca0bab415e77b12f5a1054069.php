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

/* default/template/extension/module/ldev_question/ldev_question_list.twig */
class __TwigTemplate_a01a626828ec6306e9d1c648eb1edebf2544fcf915fe8bf0bfda9790799ec201 extends \Twig\Template
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
        if (($context["heading_status"] ?? null)) {
            echo " <h4>";
            echo ($context["name"] ?? null);
            echo "</h4> ";
        }
        // line 2
        echo "<ul>
    ";
        // line 3
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["list"] ?? null));
        foreach ($context['_seq'] as $context["k"] => $context["question"]) {
            // line 4
            echo "    <li>
        <h4><span class=\"accordion-item-icon\">";
            // line 5
            echo twig_get_attribute($this->env, $this->source, $context["question"], "marker", [], "any", false, false, false, 5);
            echo "</span></h4>
        ";
            // line 6
            echo twig_get_attribute($this->env, $this->source, $context["question"], "title", [], "any", false, false, false, 6);
            echo "<br></h4>
        ";
            // line 7
            if (twig_get_attribute($this->env, $this->source, $context["question"], "thumb", [], "any", false, false, false, 7)) {
                // line 8
                echo "            ";
                if (twig_get_attribute($this->env, $this->source, $context["question"], "link", [], "any", false, false, false, 8)) {
                    // line 9
                    echo "                <a href=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["question"], "link", [], "any", false, false, false, 9);
                    echo "\"><img src=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["question"], "thumb", [], "any", false, false, false, 9);
                    echo "\" alt=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["question"], "title", [], "any", false, false, false, 9);
                    echo "\" title=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["question"], "title", [], "any", false, false, false, 9);
                    echo "\"></a>
            ";
                } else {
                    // line 11
                    echo "                <img src=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["question"], "thumb", [], "any", false, false, false, 11);
                    echo "\" alt=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["question"], "title", [], "any", false, false, false, 11);
                    echo "\" title=\"";
                    echo twig_get_attribute($this->env, $this->source, $context["question"], "title", [], "any", false, false, false, 11);
                    echo "\">
            ";
                }
                // line 13
                echo "        ";
            }
            // line 14
            echo "        <div>";
            echo twig_get_attribute($this->env, $this->source, $context["question"], "text", [], "any", false, false, false, 14);
            echo "</div>
        <div>";
            // line 15
            echo twig_get_attribute($this->env, $this->source, $context["question"], "module", [], "any", false, false, false, 15);
            echo "</div>
    </li>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['k'], $context['question'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 18
        echo "</ul>
";
    }

    public function getTemplateName()
    {
        return "default/template/extension/module/ldev_question/ldev_question_list.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  105 => 18,  96 => 15,  91 => 14,  88 => 13,  78 => 11,  66 => 9,  63 => 8,  61 => 7,  57 => 6,  53 => 5,  50 => 4,  46 => 3,  43 => 2,  37 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "default/template/extension/module/ldev_question/ldev_question_list.twig", "");
    }
}
