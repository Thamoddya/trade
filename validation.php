<?php

function validate($input, $rules)
{
    $errors = [];
    if (is_array($input)):
        foreach ($rules as $field => $fielRulse):
            $fielRulse = explode("|", $fielRulse);
            foreach ($fielRulse as $fullrule):
                $fullrule = explode(':', $fullrule);
                $rule = $fullrule[0];
                $ruleValue = isset($fullrule[1]) ? $fullrule[1] : null;
                if ($rule == 'required' && empty($input[$field])):
                    $errors[$field] = $rule;
                    break;
                elseif ($rule == 'equal' && _isEqual($input[$field], $ruleValue)):
                    $errors[$field] = $rule;
                    break;
                elseif ($rule == 'unique' && !isRecordUnique($input[$field], $ruleValue, $field)):
                    $errors[$field] = $rule;
                    break;
                elseif ($rule == 'unique-not-this' && !isRecordUniqueNotThis($input[$field], $ruleValue, $field)):
                    $errors[$field] = $rule;
                    break;
                elseif ($rule == 'email' && !filter_var($input[$field], FILTER_VALIDATE_EMAIL)):
                    $errors[$field] = $rule;
                    break;
                endif;
            endforeach;
        endforeach;
    else:
        $errors["wrong"] = 'Something is wrong';
    endif;

    return $errors;
}

function validateFile($input, $rules)
{
    $errors = [];
    if (is_array($input)):
        foreach ($rules as $field => $fielRulse):
            $fielRulse = explode("|", $fielRulse);
            foreach ($fielRulse as $fullrule):
                $fullrule = explode(':', $fullrule);
                $rule = $fullrule[0];
                $ruleValue = isset($fullrule[1]) ? $fullrule[1] : null;
                if ($rule == 'required' && !isset($input[$field])):
                    $errors[$field] = $rule;
                    break;
                elseif ($rule == 'type' && !($input[$field][$rule] == $ruleValue)):
                    $errors[$field] = $rule;
                    break;
                    // elseif($rule == 'unique' && !isRecordUnique($input[$field],$ruleValue , $field)):
                    //   $errors[$field] = $rule; 
                    //   break;
                    // elseif($rule == 'email' && !filter_var($input[$field],FILTER_VALIDATE_EMAIL)):
                    //   $errors[$field] = $rule; 
                    //   break;
                endif;
            endforeach;
        endforeach;
    else:
        $errors["wrong"] = 'Something is wrong';
    endif;

    return $errors;
}

function _isEqual($value, $arrayString)
{
    $array = explode(',', $arrayString);
    return !in_array($value, $array);
}

function isRecordUnique($input, $fieldName, $value)
{
    $sql = "SELECT * FROM `" . $fieldName . "` WHERE `" . $value . "` = '" . $input . "'";
    $result = $pdo->prepare($sql);
    $result->execute();
    $row = $result->fetch(PDO::FETCH_ASSOC);
    return !is_array($row);
}
function isRecordUniqueNotThis($input, $fieldName, $value)
{
    $sql = "SELECT * FROM `" . $fieldName . "` WHERE `" . $value . "` != '" . $input . "'";
    $getdata = $pdo->prepare($sql);
    $getdata->execute();
    $row = $getdata->fetch(PDO::FETCH_ASSOC);
    return !is_array($row);
}
/*
$validation = validate($_REQUEST, [
    'email' => 'required|email|unique:employees|min:2|max:100',
    'first_name' => 'required|min:2|max:100',
    'last_name' => 'required|min:2|max:100',
    'address' => 'required|min:2|max:250'
]);
*/

/*
f (empty($name)) {
    echo "Please Enter User Name";
  } else if (strlen($name) > 100) { max:100
    echo "Name Must Be Less Than 100 Charators";
  } else if (empty($email)) {
    echo "Please Enter User Email";
  } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid Email Address";
  } else if (strlen($email) > 64) {
    echo "Email Must Be Less Than 64 Charators";
  } else if (empty($mobile)) {
    echo "Please Enter Your Mobile Number";
  } else if (preg_match("/07[0,1,2,4,5,6,7,8][0-9]+/", $mobile) == 0) {
    echo "Invalid Mobile Number";
  } else if (strlen($mobile) != 10) {
    echo "Mobile Number Must Be 10 Charators";
    // } else if (is_numeric($mobile)) {
    //   echo "Mobile Phone Number Should Be Used Only Number";
  } else if (strlen($email) > 64) {
    echo "Email Must Be Less Than 64 Charators";
  } else if ($role == "Select") {
    echo "Please Select User Role";
  } else {
*/