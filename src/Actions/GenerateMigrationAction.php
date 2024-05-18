<?php

namespace Bunitech\DrawErd\Actions;

use Illuminate\Support\Facades\File;

class GenerateMigrationAction
{	
    /**
     * @param $request
     */
    public function execute($file)
    {
		$existingMigrations = File::files(File::dirname($file['path']));
		
		$return = 'no_changes';
        //Ensure that the directory exists
		File::ensureDirectoryExists(File::dirname($file['path']));
		
		if(File::exists($file['path'])) {
			$return = 'modified';
		} else {
			foreach($existingMigrations as $migration) {
				if($this->isRelatedMigration($migration, $file)) {
					File::delete($migration);
					
					$return = 'modified';
				} else {
					$return = 'new_file';
				}
			}
		}
		
		File::put($file['path'], $file['code']);
		
		return $return;
    }
	
	/**
     * @param $migration
     * @param $request
     * @return bool
     */
    private function isRelatedMigration($migration, $file): bool
    {
        $content = File::get($migration);
		
        $needle = 'Migration id: '.$file['key'].' ver: '.$file['ver'];

        return strpos($content, $needle) !== false;
    }
}
