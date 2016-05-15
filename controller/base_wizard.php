<?php

require_model('accesos.php');

/**
 * Description of base_wizard
 *
 * @author cmdearcos <cmdearcos@gmail.com>
 */
class base_wizard extends fs_controller{
    //put your code here
    private $accesos;
    
    
    public function __construct()
    {
        parent::__construct(__CLASS__, 'Asistente de instalación', 'admin', FALSE, FALSE);        
    }
   
    protected function private_core()
    {
        
        $this->check_menu();
        $this->accesos = new accesos();        
    }
   
    private function check_menu()
    {
        if( !$this->page->get('gestion_acceso') )
        {
            if( file_exists(__DIR__) )
            {
                /// activamos las páginas del plugin
                foreach( scandir(__DIR__) as $f)
                {
                    if( is_string($f) AND strlen($f) > 0 AND !is_dir($f) AND $f != __CLASS__.'.php' )
                    {
                        $page_name = substr($f, 0, -4);
                  
                        require_once __DIR__.'/'.$f;
                        $new_fsc = new $page_name();
                  
                        if( !$new_fsc->page->save() )
                        {
                            $this->new_error_msg("Imposible guardar la página ".$page_name);
                        }
                  
                        unset($new_fsc);
                    }
                }
            }
            else
            {
                $this->new_error_msg('No se encuentra el directorio '.__DIR__);
            }
         
            $this->load_menu(TRUE);
        }
    }    
}
