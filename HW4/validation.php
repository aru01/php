@param mixed[]
@param string[]
@param array[]

function validateForm($scheme, $form)
{
	global $validators;
	$clean = $form;
	$errors = [];

	foreach($scheme as $name => $rules)
	{
		foreach($rules as $rule)
		{
			if(is_string($rule)
			{
				$rule=$validators[$rule];
			}
				[$clean[$name], $error]=call_user_func($rule, $clean[$name]);
			
			if($error) 
			{
				$errors[$name]=$error;
				break;
			}
		}
	
	}
	return[$clean, $errors];
}

$validators = [
"require"=>"required",
"clear-extra-spaces"=>"clearExtraSpaces",
"integer"=>"integer",
"bool" => "boolean"
];

function required($value) {
return [$value, $value === "" ? "Обязательное поле" : null];
	
}

function clearExtraSpaces($value){
$value = trim($value);
if($value !== "")
{
	$value = preg_replace("/ {2,}/", " ", $value);
}
return [$value, null];
}
	


function integer($value){
if($value === "")
{
	return [$value, null];
}
$valueInt = (int) $value;

if(strval($valueInt) !== $value)
{
	$error = "Поле должно быть целым числом";
}
return [$valueInt, $error];
}
	
}
function boolean(){
	
}

@param int $min
@param int $max
@return callable
function generateRangeValidator($min = 0, $max = PHP_INT_MAX) {
  return function($value) use ($min, $max) {
    $error=null;
    if($value < $min || $value > $max)
    {
    	$error = "Значение должгл быть в промежутке от $min до $max";
    }
    return [$value, $error];
  };
}

@param int $min
@param int $max
@return callable
function generateLengthValidator($min = 0, $max = PHP_INT_MAX) {
  return function($value) use ($min, $max) {
  if($value === "")
  {
  	return [$value, null];
  }
    $length = mb_strlen($value);
    $error = null;
    if($length < $min || $length > $max)
    {
    	$error = "Длинна строки должна быть в промежутке от $min до $max";
    }
    return[$clean, $error];
  };
}


@param int $regexp
@return callable
function generateRegExpValidator($regexp) {
  return function($value) use ($regexp) {
  if($value === "")
  {
  	return[$value, null];
  }
  $error = null;
  if(!preg_match($regexp, $value))
  {
  	$error = "Строка должна соотвествовать формату $regexp"
  }
    return [$value, $error];
  };
}




