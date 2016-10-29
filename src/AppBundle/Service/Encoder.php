<?php 

	namespace AppBundle\Service;

	use Doctrine\ORM\EntityManager;
	use Doctrine\ORM\Query;

	/**
	* 
	*/
	class Encoder
	{
		public function decodeSensorStream($stream, &$credentials=null, &$decoded_stream=null)
		{


			$temp = array();
			$temp[] = $this->decoderRecursive($stream, $temp);
			$temp = array_reverse($temp);

			$credentials['mac']=$temp[0];
			$credentials['tmp']=$temp[1];
			for ($i=2; $i < count($temp); $i=$i+2) 
			{ 
				$decoded_stream[$temp[$i]]=$temp[$i+1];
			}

		}

		public function decodeCredentials($stream, &$credentials)
		{
			$temp = array();
			$temp[] = $this->decoderRecursive($stream, $temp);
			$temp = array_reverse($temp);

			$credentials['mac']=$temp[0];
			$credentials['tmp']=$temp[1];
			$credentials['attempts']=$temp[2];
		}

		private function decoderRecursive($stream, &$temp)
		{
			
			if (strlen($stream) == 0) 
			{
				return '';

			} elseif ($stream[0] == '|') 
			{
				$temp[] = $this->decoderRecursive(substr($stream, 1), $temp);
				return '';
			} 
			else
			{
				return $stream[0].$this->decoderRecursive(substr($stream, 1), $temp);
			}
			
		}

	}

?>