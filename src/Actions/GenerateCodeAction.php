<?php

namespace Bunitech\DrawErd\Actions;

use Illuminate\Support\Facades\File;

class GenerateCodeAction
{	
    /**
     * @param $request
     */
    public function execute($file)
    {
        //Ensure that the directory exists
		File::ensureDirectoryExists(File::dirname($file['path']));
		
		$fileExists = File::exists($file['path']);
		
		if($fileExists) {
			if(isset($file['export_type']) && $file['export_type'] == 'no-overwrite') {
				return 'skipped';
			}
			
			$return = 'modified';
		} else {
			$return = 'new_file';
		}

		//Delete previous file if path changed
		if(isset($file['prev_path']) && File::exists($file['prev_path'])) {
			File::delete($file['prev_path']);
		}
		
		if(isset($file['export_type']) && $file['export_type'] == 'drop') {
			if($fileExists) {
				File::delete($file['path']);
			}
			
			$return = 'deleted';
		}

		if(isset($file['export_type']) && $file['export_type'] == 'append') {
			if($fileExists) {
				$content =  File::get($file['path']);
				$needle = $file['code'];

				if(strpos($content, $needle) === false) {
					File::put($file['path'], $content . PHP_EOL . $needle);
				}
			}
		} else {
			File::put($file['path'], str_replace('[[draw-erd]]','',$file['code']));
		}
		
		return $return;
    }
}
