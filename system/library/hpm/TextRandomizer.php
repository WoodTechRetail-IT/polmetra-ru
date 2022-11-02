<?php
/**
 * Project:     Natty CMS: a PHP-based Content Management System
 * File:        Natty/TextRandomizer.php
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @link http://xbb.uz/
 * @author Dmitriy Skorobogatov <info at xbb dot uz>
 * @version 0.21
 * @copyright 2006-2009 Dmitriy Skorobogatov
 * @package Natty
 */

// Attention!
// Is customized by Serge Tkach

require_once dirname(__FILE__) . '/TextRandomizer/Node.php';

class Natty_TextRandomizer
{
    private $_text = '';

    private $_tree = null;

    private $_currentNode; // customized

    public function __construct($text = '')
    {
//        $text = (string) $text;
//        $this->_text = $text;
        $this->_tree = new Natty_TextRandomizer_Node;

//        $preg = '/
//            \\\\\\\            | # мнемонизированный слэш
//            \\\\\+             | # мнемонизированный +
//            \\\\\{             | # мнемонизированный {
//            \\\\\}             | # мнемонизированный }
//            \\\\\[             | # мнемонизированный [
//            \\\\\]             | # мнемонизированный ]
//            \\\\\|             | # мнемонизированный |
//            \\\                | # никчемный слэш
//            \[\+               | # начало разделителя
//            \+                 | # возможно, конец разделителя перетановок
//            \{                 | # начало перебора
//            \}                 | # конец перевора
//            \[                 | # начало перестановки
//            \]                 | # конец перестановки
//            \|                 | # разделитель вариантов
//            [^\\\+\{\}\[\]\|]+   # все прочее
//            /xu';
//        $currentNode = $this->_tree;
//        $currentNode = new Natty_TextRandomizer_Node($currentNode);
//        $currentNode->setType('series');
//        $currentNode = $currentNode->concat('');

        $this->_currentNode = new Natty_TextRandomizer_Node($this->_tree);

//        while (preg_match($preg, $text, $match)) {
//            switch ($match[0]) {
//                case '\\\\':
//                case '\\':
//                    $currentNode = $currentNode->concat('\\');
//                    break;
//                case '\+':
//                    $currentNode = $currentNode->concat('+');
//                    break;
//                case '\{':
//                    $currentNode = $currentNode->concat('{');
//                    break;
//                case '\}':
//                    $currentNode = $currentNode->concat('}');
//                    break;
//                case '\[':
//                    $currentNode = $currentNode->concat('[');
//                    break;
//                case '\]':
//                    $currentNode = $currentNode->concat(']');
//                    break;
//                case '\|':
//                    $currentNode = $currentNode->concat('|');
//                    break;
//                case '[+':
//                    if ('string' == $currentNode->type) {
//                        $currentNode = new Natty_TextRandomizer_Node($currentNode->parent);
//                    } else {
//                        $currentNode = new Natty_TextRandomizer_Node($currentNode);
//                    }
//                    $currentNode->isSeparator = true;
//                    break;
//                case '+':
//                    if ($currentNode->isSeparator) {
//                        $currentNode->isSeparator = false;
//                        $currentNode = new Natty_TextRandomizer_Node($currentNode);
//                        $currentNode->setType('series');
//                        $currentNode = $currentNode->concat('');
//                    } else {
//                        $currentNode = $currentNode->concat('+');
//                    }
//                    break;
//                case '{':
//                    if ('string' == $currentNode->type) {
//                        $currentNode = new Natty_TextRandomizer_Node($currentNode->parent);
//                    } else {
//                        $currentNode = new Natty_TextRandomizer_Node($currentNode);
//                    }
//                    $currentNode->setType('synonyms');
//                    $currentNode = new Natty_TextRandomizer_Node($currentNode);
//                    $currentNode->setType('series');
//                    $currentNode = $currentNode->concat('');
//                    break;
//                case '}':
//                    $is = $currentNode->parent->parent;
//                    if ($is && 'synonyms' == $is->type) {
//                        $currentNode = $is->parent;
//                        $currentNode = $currentNode->concat('');
//                    } else {
//                        $currentNode = $currentNode->concat('}');
//                    }
//                    break;
//                case '[':
//                    if ('string' == $currentNode->type) {
//                        $currentNode = new Natty_TextRandomizer_Node($currentNode->parent);
//                    } else {
//                        $currentNode = new Natty_TextRandomizer_Node($currentNode);
//                    }
//                    $currentNode = new Natty_TextRandomizer_Node($currentNode);
//                    $currentNode->setType('series');
//                    $currentNode = $currentNode->concat('');
//                    break;
//                case ']':
//                    $is = $currentNode->parent->parent;
//                    if ($is && 'mixing' == $is->type && $is->parent) {
//                        $currentNode = $is->parent;
//                        $currentNode = $currentNode->concat('');
//                    } else {
//                        $currentNode = $currentNode->concat(']');
//                    }
//                    break;
//                case '|':
//                    $is = $currentNode->parent;
//                    if ($is && 'series' == $is->type) {
//                        $currentNode = $is->parent;
//                        $currentNode = new Natty_TextRandomizer_Node($currentNode);
//                        $currentNode->setType('series');
//                        $currentNode = $currentNode->concat('');
//                    } else {
//                        $currentNode = $currentNode->concat('|');
//                    }
//                    break;
//                default:
//                    $currentNode = $currentNode->concat($match[0]);
//            }
//            $text = substr($text, strlen($match[0]));
//        }
    }

    public function getText()
    {
        return $this->_tree->getText();
    }

    // Customized by Serge Tkach . Begin
    public function setText($text) {
        $this->_text = (string) $text;
        $this->processing($this->_text);
    }

    private function processing($text) {
        $preg = '/
            \\\\\\\            | # мнемонизированный слэш
            \\\\\+             | # мнемонизированный +
            \\\\\{             | # мнемонизированный {
            \\\\\}             | # мнемонизированный }
            \\\\\[             | # мнемонизированный [
            \\\\\]             | # мнемонизированный ]
            \\\\\|             | # мнемонизированный |
            \\\                | # никчемный слэш
            \[\+               | # начало разделителя
            \+                 | # возможно, конец разделителя перетановок
            \{                 | # начало перебора
            \}                 | # конец перевора
            \[                 | # начало перестановки
            \]                 | # конец перестановки
            \|                 | # разделитель вариантов
            [^\\\+\{\}\[\]\|]+   # все прочее
            /xu';

        $this->_currentNode->setType('series');
        $this->_currentNode = $this->_currentNode->concat('');

        while (preg_match($preg, $text, $match)) {
            switch ($match[0]) {
                case '\\\\':
                case '\\':
                    $this->_currentNode = $this->_currentNode->concat('\\');
                    break;
                case '\+':
                    $this->_currentNode = $this->_currentNode->concat('+');
                    break;
                case '\{':
                    $this->_currentNode = $this->_currentNode->concat('{');
                    break;
                case '\}':
                    $this->_currentNode = $this->_currentNode->concat('}');
                    break;
                case '\[':
                    $this->_currentNode = $this->_currentNode->concat('[');
                    break;
                case '\]':
                    $this->_currentNode = $this->_currentNode->concat(']');
                    break;
                case '\|':
                    $this->_currentNode = $this->_currentNode->concat('|');
                    break;
                case '[+':
                    if ('string' == $this->_currentNode->type) {
                        $this->_currentNode = new Natty_TextRandomizer_Node($this->_currentNode->parent);
                    } else {
                        $this->_currentNode = new Natty_TextRandomizer_Node($this->_currentNode);
                    }
                    $this->_currentNode->isSeparator = true;
                    break;
                case '+':
                    if ($this->_currentNode->isSeparator) {
                        $this->_currentNode->isSeparator = false;
                        $this->_currentNode = new Natty_TextRandomizer_Node($this->_currentNode);
                        $this->_currentNode->setType('series');
                        $this->_currentNode = $this->_currentNode->concat('');
                    } else {
                        $this->_currentNode = $this->_currentNode->concat('+');
                    }
                    break;
                case '{':
                    if ('string' == $this->_currentNode->type) {
                        $this->_currentNode = new Natty_TextRandomizer_Node($this->_currentNode->parent);
                    } else {
                        $this->_currentNode = new Natty_TextRandomizer_Node($this->_currentNode);
                    }
                    $this->_currentNode->setType('synonyms');
                    $this->_currentNode = new Natty_TextRandomizer_Node($this->_currentNode);
                    $this->_currentNode->setType('series');
                    $this->_currentNode = $this->_currentNode->concat('');
                    break;
                case '}':
                    $is = $this->_currentNode->parent->parent;
                    if ($is && 'synonyms' == $is->type) {
                        $this->_currentNode = $is->parent;
                        $this->_currentNode = $this->_currentNode->concat('');
                    } else {
                        $this->_currentNode = $this->_currentNode->concat('}');
                    }
                    break;
                case '[':
                    if ('string' == $this->_currentNode->type) {
                        $this->_currentNode = new Natty_TextRandomizer_Node($this->_currentNode->parent);
                    } else {
                        $this->_currentNode = new Natty_TextRandomizer_Node($this->_currentNode);
                    }
                    $this->_currentNode = new Natty_TextRandomizer_Node($this->_currentNode);
                    $this->_currentNode->setType('series');
                    $this->_currentNode = $this->_currentNode->concat('');
                    break;
                case ']':
                    $is = $this->_currentNode->parent->parent;
                    if ($is && 'mixing' == $is->type && $is->parent) {
                        $this->_currentNode = $is->parent;
                        $this->_currentNode = $this->_currentNode->concat('');
                    } else {
                        $this->_currentNode = $this->_currentNode->concat(']');
                    }
                    break;
                case '|':
                    $is = $this->_currentNode->parent;
                    if ($is && 'series' == $is->type) {
                        $this->_currentNode = $is->parent;
                        $this->_currentNode = new Natty_TextRandomizer_Node($this->_currentNode);
                        $this->_currentNode->setType('series');
                        $this->_currentNode = $this->_currentNode->concat('');
                    } else {
                        $this->_currentNode = $this->_currentNode->concat('|');
                    }
                    break;
                default:
                    $this->_currentNode = $this->_currentNode->concat($match[0]);
            }
            $text = substr($text, strlen($match[0]));
        }
    }

    // Customized by Serge Tkach . End

    public function numVariant()
    {
        return $this->_tree->numVariant();
    }
}
