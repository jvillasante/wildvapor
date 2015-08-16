<?php

namespace Helpers;

class Form {
  public static function create_input($name, $type, $errors, $values = 'POST', $extras = array()) {
    $value = false;

    if ($values == 'SESSION') {
      if (isset($_SESSION['slim.flash']['data'][$name])) { $value = $_SESSION['slim.flash']['data'][$name]; }
    } elseif ($values == 'POST') {
      if (isset($_POST[$name])) { $value = $_POST[$name]; }
    } elseif ($values == 'GET') {
      if (isset($_GET[$name])) { $value = $_GET[$name]; }
    }

    if (($type == 'text') || ($type == 'password') ) { // Create text or password inputs.
      echo '<div class="controls">';
      echo '<input type="' . $type . '" name="' . $name . '" id="' . $name . '"';

      // Add the value to the input:
      if ($value) { echo ' value="' . htmlspecialchars($value) . '"'; }

      if (array_key_exists('others', $extras)) {
        echo ' ' . $extras['others'];
      }

      if (array_key_exists($name, $errors)) {
        $extras['class'] .= ' error';
      }

      if (array_key_exists('class', $extras)) {
        echo ' class="' . $extras['class'] . '" />';
      }

      if (array_key_exists($name, $errors)) {
        echo '<span class="error">' . implode(' | ', $errors[$name]) . '</span>';
      }

      echo '</div>';
    } elseif ($type == 'select') {
      if (($name == 'state') || ($name == 'shipping_state') || ($name == 'billing_state') || ($name == 'cc_state')) { // Create a list of states.
        $data = array('' => 'Region / State:', 'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina', 'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming');
      } elseif ($name == 'country') {
        $data = array('' => 'Country:', 'US' => 'United States of America');
      } elseif ($name == 'cc_exp_month') { // Create a list of months.
        $data = array('' => 'Month:', '1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' =>  'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December');
      } elseif ($name == 'cc_exp_year') { // Create a list of years.
        $data = array('' => 'Year:');
        $start = date('Y'); // Start with current year.
        for ($i = $start; $i <= $start + 10; $i++) { // Add five more.
          $data[$i] = $i;
        }
      }

      echo '<div class="controls">';
      echo '<select name="' . $name  . '"';
      if (array_key_exists($name, $errors)) { echo ' class="error"'; }
      echo '>';

      foreach ($data as $k => $v) {
        echo "<option value=\"$k\"";
        if ($value == $k) { echo ' selected="selected"'; }
        echo ">$v</option>";
      }

      echo '</select>';

      if (array_key_exists($name, $errors)) {
        echo '<br /><span class="error">' . implode(' | ', $errors[$name]) . '</span>';
      }

      echo '</div>';
    } else if ($type == 'checkbox') {
      echo '<label class="checkbox inline">';
      echo '<input type="' . $type . '" name="' . $name . '" id="' . $name . '"';
      if ($value) { echo ' checked'; }
      echo ' /></label>';
    } else if ($type == 'textarea') {
      echo '<textarea name="' . $name . '" id="' . $name . '" rows="10" cols="20"';

      // Add the error class, if applicable:
      if (array_key_exists($name, $errors)) {
        echo ' class="error">';
      } else {
        echo '>';
      }

      // Add the value to the textarea:
      if ($value) { echo $value; }

      // Complete the textarea:
      echo '</textarea>';
    }
  }

  public static function create_attributes_for_kit($attributes, $name = 'attr_') {
    $count = count($attributes);
    for ($i = 0; $i < $count; $i++) {
      $attr = $attributes[$i];
      $attr_prev = ($i == 0) ? NULL : $attributes[$i - 1];
      $attr_next = ($i == $count - 1) ? NULL : $attributes[$i + 1];
      if (($i == 0) || ($attr['name'] !== $attr_prev['name'])) {
        echo '<select name="product_attrs[' . $name . $attr['name'] . ']">';
        echo '<option value="">';
        echo $attr['name'] . ':';
        echo '</option>';
      }
      echo '<option value="' . $attr['value'] . '">';
      echo $attr['value'];
      echo '</option>';
      if (($i == $count - 1) || ($attr['name'] != $attr_next['name'])) {
        echo '</select>' . '  ';
      }
    }
  }

  public static function create_attributes($attributes, $name = 'attr_') {
    $count = count($attributes);
    for ($i = 0; $i < $count; $i++) {
      $attr = $attributes[$i];
      $attr_prev = ($i == 0) ? NULL : $attributes[$i - 1];
      $attr_next = ($i == $count - 1) ? NULL : $attributes[$i + 1];
      if (($i == 0) || ($attr['name'] !== $attr_prev['name'])) {
        echo '<select name="' . $name . $attr['name'] . '">';
        echo '<option value="">';
        echo $attr['name'] . ':';
        echo '</option>';
      }
      echo '<option value="' . $attr['value'] . '">';
      echo $attr['value'];
      echo '</option>';
      if (($i == $count - 1) || ($attr['name'] != $attr_next['name'])) {
        echo '</select>' . '  ';
      }
    }
  }
}
