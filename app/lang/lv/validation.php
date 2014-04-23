<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => "Laukam :attribute jābūt akceptētam.",
	"active_url"           => "Lauks :attribute nav derīga URL.",
	"after"                => "Laukam :attribute jābūt datumam pēc :date.",
	"alpha"                => "Lauks :attribute var saturēt tikai burtus.",
	"alpha_dash"           => "Lauks :attribute var saturēt tikai burtus, ciparus, un domuzīmes.",
	"alpha_num"            => "Lauks :attribute var saturēt tikai burtus un ciparus.",
	"array"                => ":attribute jābūt masīvam.",
	"before"               => ":attribute jābūt datumam pirms :date.",
	"between"              => array(
		"numeric" => "Laukam :attribute jābūt skaitlim no :min līdz :max.",
		"file"    => "Laukam :attribute jābūt no :min līdz :max kilobaitiem.",
		"string"  => "Laukam :attribute jābūt no :min līdz :max simboliem.",
		"array"   => "Laukam :attribute jāsatur no :min līdz :max ierakstiem.",
	),
	"confirmed"            => "Lauka :attribute apstiprinājums nesakrīt.",
	"date"                 => "Lauks :attribute nav derīgs datums.",
	"date_format"          => "Lauks :attribute neatbilst sekojošam formātam :format.",
	"different"            => "The :attribute and :other must be different.",
	"digits"               => "The :attribute must be :digits digits.",
	"digits_between"       => "The :attribute must be between :min and :max digits.",
	"email"                => ":attribute jābūt derīgai e-pasta adresei.",
	"exists"               => "The selected :attribute is invalid.",
	"image"                => ":attribute jābūt attēlam.",
	"in"                   => "The selected :attribute is invalid.",
	"integer"              => "The :attribute must be an integer.",
	"ip"                   => "The :attribute must be a valid IP address.",
	"max"                  => array(
		"numeric" => "The :attribute may not be greater than :max.",
		"file"    => "The :attribute may not be greater than :max kilobytes.",
		"string"  => ":attribute nedrīkst būt garāks par :max simboliem.",
		"array"   => "The :attribute may not have more than :max items.",
	),
	"mimes"                => "The :attribute must be a file of type: :values.",
	"min"                  => array(
		"numeric" => "The :attribute must be at least :min.",
		"file"    => "The :attribute must be at least :min kilobytes.",
		"string"  => ":attribute jābūt vismaz :min simboliem.",
		"array"   => "The :attribute must have at least :min items.",
	),
	"not_in"               => "The selected :attribute is invalid.",
	"numeric"              => "The :attribute must be a number.",
	"regex"                => "The :attribute format is invalid.",
	"required"             => ":attribute ir obligāti aizpildāms lauks.",
	"required_if"          => "The :attribute field is required when :other is :value.",
	"required_with"        => "The :attribute field is required when :values is present.",
	"required_with_all"    => "The :attribute field is required when :values is present.",
	"required_without"     => "The :attribute field is required when :values is not present.",
	"required_without_all" => "The :attribute field is required when none of :values are present.",
	"same"                 => ":attribute un :other nesakrīt.",
	"size"                 => array(
		"numeric" => "The :attribute must be :size.",
		"file"    => "The :attribute must be :size kilobytes.",
		"string"  => "The :attribute must be :size characters.",
		"array"   => "The :attribute must contain :size items.",
	),
	"unique"               => ":attribute ir jau aizņemts.",
	"url"                  => ":attribute nederīgs formāts.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute.rule" to name the lines. This makes it quick to
	| specify a specific custom language line for a given attribute rule.
	|
	*/

	'custom' => array(
		'email' => array(
			'required' => 'Jūs nenorādījāt savu e-pasta adresi',
			'email' => 'Nederīga e-pasta adrese, lūdzu pārbaudi un mēģini vēlreiz',
		),
		'first_name' => array(
			'required' => 'Jūs nenorādījāt savu vārdu',
			'alpha' => 'Vārds var saturēt tikai burtus',
			'min:2' => 'Vārdam jāsastāv no vismaz 2 burtiem',
		),
		'last_name' => array(
			'required' => 'Jūs nenorādījāt savu uzvārdu',
			'alpha' => 'Uzārds var saturēt tikai burtus',
			'min:2' => 'Uzvārdam jāsastāv no vismaz 2 burtiem',
		),
		'old_password' => array(
			'required' => 'Jūs nenorādījāt savu patreizējo paroli',
		),
		'password' => array(
			'required' => 'Jūs nenorādījāt savu paroli',
			'alpha_num' => 'Parole var saturēt tikai burtus un ciparus',
			'between:6,12' => 'Parolei jābūt no 6 līdz 12 simboliem',
			'confirmed' => 'Liekas, ka abas reizes neievadīji vienu un to pašu jauno paroli',
		),
		'cover_image' => array(
			'image' => 'Pievienotais fails nav bilde',
		),
		'title' => array(
			'required' => 'Lūdzu norādiet nosaukumu',
		),
		'description' => array(
			'required' => 'Lūdzu norādiet aprakstu',
		),
		'link' => array(
			'url' => 'Ievadīta nederīga saite',
		),
		'url' => array(
			'required' => 'Aizmirsi norādīt sev vēlamo saiti?',
			'unique' => 'Kāds jau ir pasteidzies un šo saiti aizņēmis.',
			'between' => 'Saitei jāsatur vismaz 5 simbolus un nedrīkst pārsniegt 20.',
			'alpha_num' => 'Saitē var būt tikai burti un cipari.',
		),

	),


	/*
	|--------------------------------------------------------------------------
	| Custom Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as E-Mail Address instead
	| of "email". This simply helps us make messages a little cleaner.
	|
	*/

	'attributes' => array(
		'email' => 'E-pasts',
		'first_name' => 'Vārds',
		'last_name' => 'Uzvārds',
		'old_password' => 'Pašreizējā parole',
		'password' => 'Parole',
		'cover_image' => 'Vāka attēls',
		'title' => 'Nosaukums',
		'description' => 'Apraksts',
		'link' => 'Saite',
	),

);
