<?php

function validate($data) {
$phone_regex = "/^
        (?:                                 # Area Code
            (?:
                \(                          # Open Parentheses
                (?=\d{3}\))                 # Lookahead.  Only if we have 3 digits and a closing parentheses
            )?
            (\d{3})                         # 3 Digit area code
            (?:
                (?<=\(\d{3})                # Closing Parentheses.  Lookbehind.
                \)                          # Only if we have an open parentheses and 3 digits
            )?
            [\s.\/-]?                       # Optional Space Delimeter
        )?
        (\d{3})                             # 3 Digits
        [\s\.\/-]?                          # Optional Space Delimeter
        (\d{4})\s?                          # 4 Digits and an Optional following Space
        (?:                                 # Extension
            (?:                             # Lets look for some variation of 'extension'
                (?:
                    (?:e|x|ex|ext)\.?       # First, abbreviations, with an optional following period
                |
                    extension               # Now just the whole word
                )
                \s?                         # Optionsal Following Space
            )
            (?=\d+)                         # This is the Lookahead.  Only accept that previous section IF it's followed by some digits.
            (\d+)                           # Now grab the actual digits (the lookahead doesn't grab them)
        )?                                  # The Extension is Optional
        $/x";                               // /x modifier allows the expanded and commented regex

  $v = new \Valitron\Validator($data);
  $v->rule('required', 'first_name')->message('First Name is required.');
  $v->rule('required', 'last_name')->message('Last Name is required.');
  $v->rule('required', 'email')->message('Email Addres is required.');
  $v->rule('required', 'username')->message('Username is required.');
  $v->rule('required', 'password')->message('Password is required.');
  $v->rule('required', 'password_confirmation')->message('Password Confirmation is required.');
  $v->rule('required', 'terms')->message('You must accept our terms of service and privacy policy.');

  $v->rule('regex', 'first_name', '/^[A-Z \'.-]{2,30}$/i')->message('First Name contains invalid characters.');
  $v->rule('regex', 'last_name', '/^[A-Z \'.-]{2,40}$/i')->message('Last Name contains invalid characters.');
  $v->rule('email', 'email')->message('Email Address is not a valid email address.');
  $v->rule('max', 'email', 80)->message('Email Address must be less than 80 characters.');
  $v->rule('regex', 'phone', $phone_regex)->message('Phone Number contains invalid characters.');
  $v->rule('regex', 'username', '/^[A-Z0-9]{2,30}$/i')->message('Username contains invalid characters.');
  $v->rule('regex', 'password', '/^\S*(?=\S{6,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W]*)\S*$/')->message('Password contains invalid characters.');
  $v->rule('equals', 'password_confirmation', 'password')->message('Password Confirmation be the same as Password.');
  $v->rule('regex', 'address1', '/^[A-Z0-9 \',.#-]{2,80}$/i')->message('Address1 contains invalid characters.');
  $v->rule('regex', 'address2', '/^[A-Z0-9 \',.#-]{2,80}$/i')->message('Address2 contains invalid characters.');
  $v->rule('regex', 'city', '/^[A-Z \'.-]{2,60}$/i')->message('City contains invalid characters.');
  $v->rule('regex', 'state', '/^[A-Z]{2}$/')->message('State contains invalid characters.');
  $v->rule('regex', 'zip_code', '/^(\d{5}$)|(^\d{5}-\d{4})$/')->message('Zip Code contains invalid characters.');
  $v->rule('accepted', 'terms')->message('You must read and agree to our Privacy Policy.');

  if($v->validate()) {
    return null;
  } else {
    return $v->errors();
  }
}
