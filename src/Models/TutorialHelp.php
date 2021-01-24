<?php

namespace Oka6\Admin\Models;

use Illuminate\Http\Request;
use Jenssegers\Mongodb\Eloquent\Model;

class TutorialHelp extends Model {
	
	const TABLE = 'tutorial_help';
	protected $fillable = ['title', 'description'];
	protected $connection = 'oka6_admin';
	protected $table = 'tutorial_help';
	
	public static function createTutorial(Request $request) {
		$tutorial = new TutorialHelp;
		$tutorial['id'] = Sequence::getSequence(TutorialHelp::TABLE);
		$tutorial['title'] = $request->get('title');
		$tutorial['description'] = (binary)$request->get('description');
		$tutorial->save();
	}
	
	public static function updateTutorial(Request $request, $id) {
		//$tutorial  = TutorialHelp::where('id',(int)$id)->first();
		$tutorial = TutorialHelp::where(['id' => (int)$id])->first();
		$tutorial['title'] = $request->get('title');
		$tutorial['description'] = (binary)$request->get('description');
		$tutorial->save();
	}
	
	public static function deleteTutorial($id) {
		$tutorial = TutorialHelp::where(['id' => (int)$id])->first();
		$tutorial->delete();
	}
	
}
