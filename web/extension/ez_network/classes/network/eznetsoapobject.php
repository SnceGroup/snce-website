<?php
/**
 * File containing eZNetSOAPObject class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetSOAPObject eznetsoapobject.php
  \brief The class eZNetSOAPObject does

*/
class eZNetSOAPObject extends eZPersistentObject
{
    /*!
     Constructor
    */
    function eZNetSOAPObject( $row )
    {
        $this->eZPersistentObject( $row );
    }

    /*!
     Fetch missing object list specified by eZNetSOAP object ( using the eZNetSOAPLog )
    */
    static function fetchMissingObjectList( $eZNetSOAP )
    {
        $latestLogEntry = $eZNetSOAP->latestLogEntry();
        $lastEventTS = 0;

        if ( $latestLogEntry )
        {
            $lastEventTS = $latestLogEntry->attribute( 'timestamp' );
        }

        $className = $eZNetSOAP->attribute( 'local_class' );
        $classDefinition = call_user_func( array( $className, 'definition' ) );

        return eZPersistentObject::fetchObjectList( $classDefinition,
                                                    null,
                                                    array( 'timestamp' => array( '>', $lastEventTS ) ) );
    }

    /*!
     Create string representation of current object
    */
    function soapString()
    {
        $definition = $this->definition();

        $objectArray = array();
        foreach( array_keys( $definition['fields'] ) as $attributeName )
        {
            $objectArray[$attributeName] = $this->attribute( $attributeName );
        }

        return serialize( $objectArray );
    }

    /*!
      Get local ID
    */
    function soapLocalID()
    {
        return $this->attribute( 'id' );
    }
}

?>
