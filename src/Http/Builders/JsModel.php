<?php
namespace Elsayednofal\EasyCrud\Http\Builders;
use LaravelBook\Ardent\Ardent;
// You can extend Eloquent
// Example: http://laravel.io/bin/89V7
class JsModel extends Ardent {
	
	/**
	 * Mapping in an array of Laravel Validator class rules
	 * and jQuery validator rules in format as
	 * Laravel Rule => jQuery Rule"
	 */
	private static $mappedRules = array(
		'required'	=>	'required: true',
		//'remote'	=>	'Not implemented'
		'min:(.*)'	=>	'minlength: $1',
		'max:(.*)'	=>	'maxlength: $1',
		'between:(.*),(.*)'	=>	'rangelength: [$1, $2]',
		'email'	=>	'email: true',
		'url'	=>	'url: true',
		'date'	=> 'date: true',
		'integer'	=> 'digits: true',
		'numeric'	=> 'number: true',
		'same:(.*)'	=>	'equalTo: "#$1"',
	);
	/**
	 * Convert the Laravel $rules array to jQuery validate method.
	 *
	 * @param  string  $selector
	 * @param  array $rules optional Laravel validation rules array
	 * @return  string  JQuery code
	 */ 
	public static function JsValidate($selector, $rules = array())
	{
		// Overrie the rules if specified
		if(count($rules) > 0){
			static::$rules = $rules;
		}
		$js = '$("'.$selector.'").validate({';
		$js .= 'rules: {';
		$tags = array();
		foreach(static::$rules as $field => $rule)
		{
			$tags[$field] = $field.': {';
			if(! is_array($rule))
			{
				$rule = explode('|', $rule);
			}
			$rolls = array();
			foreach($rule as $r)
			{
				$replaced = false;
				foreach(self::$mappedRules as $laravelRule => $jQueryRule)
				{
					$r = preg_replace('/'.$laravelRule.'/', $jQueryRule, $r);
				
					if($r == $jQueryRule)
					{
						$replaced = true;
					}
				}
				
				if($replaced == true)
				{
					$rolls[] = $r;
				}
			}
			$tags[$field] .= implode(', ', $rolls);
			$tags[$field] .= '}';
		}
		$js .= implode(', ', $tags);
		$js .= '}});';
		return $js;
	}
	/**
	 * Render out the filter section
	 * 
	 * @return string
	 */
	public static function filterForm()
	{
		$html = '
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default gradient">
					<div class="panel-heading">
						<h4>Filter</h4>
						<a href="#" class="minimize">Minimize</a>
					</div>
					<div class="panel-body clearfix">
						<form class="form-vertical" action="'.URL::current().'" method="get">
							'.Form::token();
		
		$i = 0;
		foreach(static::$filterAttributes as $attribute => $data)
		{
			$label = $data;
			
			if($i == 0)
			{
				$html .= '<div class="row">';
			}
			$value = Input::get($attribute);
			if(is_array($value))
			{
				$value = implode(',', $value);
			}
			$field = '<input class="form-control" type="text" name="'.$attribute.'" id="'.$attribute.'" value="'.$value.'" />';
			if(is_array($data))
			{
				$label = $data['label'];
				if(isset($data['field']))
				{
					$field = $data['field'];
				}
			}
			$html .= '
				<div class="form-group">
					<label class="col-lg-1" for="'.$attribute.'">'.$label.'</label>
					<div class="col-lg-2">
						'.$field.'
					</div>
				</div>
			';
			$i++;
			if($i == 4)
			{
				$i = 0;
				$html .= '</div>';
			}
		}
		$html .='			
							<div class="form-group">
								<div class="col-lg-1">
									<button class="btn btn-info form-control" type="submit" name="btnFilter">Filter</button>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-1">
									<a class="btn btn-danger" href="'.URL::current().'"">Reset</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>';
		return $html;
	}
	/**
	 * Apply the filter sent with the request.
	 *
	 * @return self
	 */
	public static function scopeFilter($query)
	{
		foreach(static::$filterAttributes as $attribute => $data)
		{
			if(Input::get($attribute) != null)
			{
				if(is_array($data) && isset($data['filter']))
				{
					$data['filter']($query);
				}
				else
				{
					if(is_array(Input::get($attribute)))
					{
						foreach(Input::get($attribute) as $value)
						{
							$query->orWhere($attribute, '=', $value);
						}
					}
					else
					{
						$query->where($attribute, 'LIKE', '%'.Input::get($attribute).'%');
					}
				}
			}
		}
	}
}

