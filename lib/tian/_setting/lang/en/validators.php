<?php
/**
 * @author awei.tian
 * date: 2013-9-26
 * 说明:
 */
return array(
	"validators.integer"=>'integer',
	"validators.numeric"=>'numeric',
	"validators.date"=>'date',
	"validators.url"=>'url',
	"validators.email"=>'email address',
	"validators.not_allow_blank"=>'{$attribute} cannot be blank.',
	"validators.must_be_repeated_exactly"=>'{$attribute} must be repeated exactly.',
	"validators.must_not_be_equal_to"=>'{$attribute} must not be equal to "{$compareValue}".',
	"validators.must_be_greater_than"=>'{$attribute} must be greater than "{$compareValue}".',
	"validators.must_be_greater_than"=>'{$attribute} must be greater than "{$compareValue}".',
	"validators.is_not_a_valid"=>'{$attribute} is not a valid {$name}.',
	"validators.is_invalid"=>'{$attribute} is invalid.',
	"validators.is_too_short"=>'{$attribute} is too short (minimum is {$min} characters).',
	"validators.is_too_long"=>'{$attribute} is too long (maximum is {$max} characters).',
	"validators.is_of_the_wrong_length"=>'{$attribute} is of the wrong length (should be {$length} characters).',
);