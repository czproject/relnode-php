<?php
	/** Heymaster RelNode Class
	 * 
	 * @author		Jan Pecha, <janpecha@email.cz>
	 */
	
	namespace Cz;
	
	class RelNode
	{
		/** @var  string */
		public $dir;
		
		/** @var  array */
		public $children = array();
		
		/** @var  mixed|NULL */
		public $value = NULL;
		
		
		
		/**
		 * @param	string|string[]
		 * @param	mixed|NULL
		 * @return	bool
		 */
		public function addChild($dir, $value)
		{
			if(is_string($dir))
			{
				$dir = trim(trim($dir), '/');
			}
			
			if(self::isEmpty($dir))
			{
				$this->value = $value;
				return TRUE;
			}
			
			if(!is_array($dir))
			{
				$dir = explode('/', $dir);
			}
			
			$dir = self::clearDirPath($dir);
			
			if($this->dir !== NULL && $this->dir !== ''/*FS root*/)
			{
				if($this->dir !== reset($dir))
				{
					return FALSE; // TODO: throw exception??
				}
				
				array_shift($dir); // $this->dir === $dir[0]
			}
			
			$childDir = reset($dir);
			
			if($childDir === FALSE)
			{
				$this->value = $value;
				return TRUE;
			}
			
			if(!isset($this->children[$childDir]))
			{
				$this->children[$childDir] = self::create($childDir, NULL);
			}
			
			$this->children[$childDir]->addChild($dir, $value);
			return TRUE;
		}
		
		
		
		/**
		 * @return	RelNode|FALSE
		 */
		public function getFirstFilled()
		{
			if($this->value !== NULL)
			{
				return $this;
			}
			
			foreach($this->children as $child)
			{
				$res = $child->getFirstFilled();
				
				if($res !== NULL || $res !== FALSE)
				{
					return $res;
				}
			}
			
			return FALSE;
		}
		
		
		
		/**
		 * @return	RelNode[]
		 */
		public function getNearestChildren()
		{
			$nearest = array();
			
			foreach($this->children as $childNode)
			{
				if($childNode->value !== NULL)
				{
					$nearest[] = $childNode;
				}
				else
				{
					$nearest = array_merge($nearest, $childNode->getNearestChildren());
				}
			}
			
			return $nearest;
		}
		
		
		
		/**
		 * @param	string
		 * @param	mixed|NULL
		 * @return	RelNode
		 */
		public static function create($dir, $value)
		{
			$node = new static;
			$node->dir = $dir;
			$node->value = $value;
			
			return $node;
		}
		
		
		
		/**
		 * @param	string|array
		 * @param	bool
		 * @return	bool
		 */
		protected static function isEmpty($var, $onlyScalar = FALSE)
		{
			if($var === NULL || $var === FALSE || $var === '')
			{
				return TRUE;
			}
			elseif(is_array($var) && !$onlyScalar)
			{
				if(empty($var))
				{
					return TRUE;
				}
				
				foreach($var as $value)
				{
					if(!self::isEmpty($value, TRUE))
					{
						return FALSE;
					}
				}
				
				return TRUE;
			}
			
			return FALSE;
		}
		
		
		
		/**
		 * @param	array
		 * @return	array
		 */
		protected static function clearDirPath(array $path)
		{
			$newPath = array();
			
			foreach($path as $value)
			{
				if(!self::isEmpty($value, TRUE))
				{
					$newPath[] = $value;
				}
			}
			
			return $newPath;
		}
	}

