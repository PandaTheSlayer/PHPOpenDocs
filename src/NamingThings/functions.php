<?php

declare(strict_types = 1);

namespace NamingThings;

use OpenDocs\EditInfo;

function createEditInfo(string $file, ?int $line): EditInfo
{
    $path = normaliseFilePath($file);

    $link = 'https://github.com/PHPOpenDocs/PHPOpenDocs/blob/main/' . $path;

    if ($link !== null) {
        $link .= '#L' . $line;
    }

    return new EditInfo(
        'Edit page',
        $link
    );
}

function noun_link(string $noun)
{
    return "<a href='/naming/nouns#" . $noun . "'>" . $noun . "</a>";
}

function verb_link(string $verb)
{
    return "<a href='/naming/verbs#" . $verb . "'>" . $verb . "</a>";
}



/**
 * @param Noun[] $nouns
 * @return string
 */
function renderNouns(array $nouns): string
{
    $content = <<< HTML
<h1>Common nouns for types</h1>

<p>
  Naming things is hard. Below is a list of nouns that can be used as names for types (aka classes in PHP) with  with descriptions of how the thing they commonly represent. The list should be considered more what you'd call <em>guidelines</em> than actual rules.
</p>
HTML;

    $content .= "<table class='nouns_table'><tbody>";

    $verb_template = <<< HTML
<tr>
  <td>
    <a href="#:attr_noun_name">:html_noun_name</a> 
  </td>
  <td>
    :raw_description
  </td>
  <td>
    :html_see_also
  </td>
</tr>
HTML;

    foreach ($nouns as $noun) {
        $params = [
            ':attr_noun_name' => $noun->getName(),
            ':html_noun_name' => $noun->getName(),
            ':raw_description' => $noun->getDescription(),
            ':html_see_also' => implode(',', $noun->getAlso())
        ];

        $content .= esprintf($verb_template, $params);
    }

    $content .= '</tbody></table>';

    return $content;
}

function getVerbSeeAlsoLinks($alsos): string
{
    $links = [];
    foreach ($alsos as $also) {
        $links[] = verb_link($also);
    }

    return implode(',', $links);
}

/**
 * @param Verb[] $verbs
 * @return string
 */
function renderVerbs(array $verbs): string
{
    $content = "";

    $content .= <<< HTML

<h1>Common verbs for function / method names</h1>

<p>
  Naming things is hard. Below is a list of verbs that can be used as names for either functions or class methods with descriptions of how they commonly behave. The list should be considered more what you'd call <em>guidelines</em> than actual rules.
</p>

<h2>Good names</h2>

<table class='verbs_table'>
  <thead>
    <tr>
      <th>Name</th>
      <th>Description</th>
      <th style="min-width: 100px">See also</th>    
    </tr>  
  </thead>
HTML;

    $content .= "<tbody>";

    $verb_template = <<< HTML
<tr>
  <td>
    <a href="#:attr_verb_name">:html_verb_name</a> 
  </td>
  <td>
    :raw_description
  </td>
  <td>
    :raw_see_also
  </td>
</tr>
HTML;

    foreach ($verbs as $verb) {
        $params = [
            ':attr_verb_name' => $verb->getName(),
            ':html_verb_name' => $verb->getName(),
            ':raw_description' => $verb->getDescription(),
            ':raw_see_also' => getVerbSeeAlsoLinks($verb->getAlso()) //implode(',', $verb->getAlso())
        ];

        $content .= esprintf($verb_template, $params);
    }

    $content .= '</tbody></table>';

    $bad_functions = <<< HTML

<h2>Bad names</h2>


Maybe we should have a list of bad names here e.g. 'make'... is that 'create' or is it 'execute'?

HTML;

    $content .= $bad_functions;

    return $content;
}
