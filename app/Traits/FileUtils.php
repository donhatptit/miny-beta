<?php
/**
 * Created by PhpStorm.
 * User: hocvt
 * Date: 7/25/16
 * Time: 09:40
 */

namespace App\Traits;



trait FileUtils {

	private $tmp_files = [];
	/**
	 * Tạo 1 file tạm tự động xóa
	 *
	 * @param null|string|resource $input
	 *
	 * @param bool $is_content xác định input là content hay path
	 *
	 * @param string $wm
	 *
	 * @return string
	 */
	protected function newTmp($input = null,$id_post = null, $is_content = true, $wm = 'w+'){
        if($id_post !== null){
            $filename = tempnam(storage_path("media/".$id_post), 'Chv');
        }else{
            $filename = tempnam(storage_path("media"), 'Chv');
         }

		$this->tmp_files[] = $filename;
		if($input != null){
			if(is_resource($input)){
				$ft = fopen($filename, $wm);
				while($block = fread($input, 4096)){
					fwrite($ft, $block);
				}
				fclose($ft);
			}elseif($is_content){
				file_put_contents($filename, $input);
			}else{
				$fi = fopen($input, 'rb');
				$ft = fopen($filename, 'wb');
				while($block = fread($fi, 4096)){
					fwrite($ft, $block);
				}
				fclose($fi);
				fclose($ft);
			}
		}
		return $filename;
	}



	/**
	 * @return string
	 * @throws \Exception
	 */
	private function newTmpFolder($name = 'GldocConverter'){
		$filename = tempnam(storage_path('tmp'), $name);

		if (file_exists($filename)) { \File::delete($filename); }
		$filename = dirname($filename) . DIRECTORY_SEPARATOR . preg_replace('/\./', '_', basename($filename));
		if(\File::makeDirectory($filename, 0777, true) === false){
			mkdir($filename, '0777', true);
		}
		if (!is_dir($filename)) {
			throw new \Exception("Can not create tmp folder");
		}
		$this->tmp_files[] = $filename;
		return $filename;
	}

	/**
	 * Danh sách file tạm đã tạo
	 * @return array
	 */
	private function listTmp(){
		return $this->tmp_files;
	}
}