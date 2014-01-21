<?php
/**
 * File containing eZNetSOAPSyncAdvanced class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetSOAPSyncAdvanced eznetsoapsyncadvanced.php
  \brief The class eZNetSOAPSyncAdvanced does

*/
class eZNetSOAPSyncAdvanced extends eZNetSOAPSync
{

    /*!
     \reimp
    */
    static function functionDefinitionList()
    {
        return array_merge( eZNetSOAPSync::functionDefinitionList() );
    }


    /*!
     \static
     Calculate dependencies of list classes to syncronize. TODO : use more efficient algo than brute force.

     \param list of classes to syncronize.

     \return Ordered list of classes to syncronize
    */
    static function orderClassListByDependencies( $classList )
    {
        $tmpDependencyList = array();

        // build rough depency list
        foreach( $classList as $className )
        {
            $tmpDependencyList[$className] = array();

            // this causes a seg fault: (see issue #001996 in network-project issue tracker)
            //$definition = call_user_func_array( array( $className, "definition" ),
            //                                    array() );

            $definition = call_user_func( array( $className, "definition" ) );

            foreach( $definition['fields'] as $attributeDefinition )
            {
                if ( isset( $attributeDefinition['foreign_class'] ) )
                {
                    $tmpDependencyList[$className][] = $attributeDefinition['foreign_class'];
                }
                if ( isset( $attributeDefinition['foreign_override_class'] ) )
                {
                    $tmpDependencyList[$attributeDefinition['foreign_override_class']][] = $className;
                }
            }
        }

        // cleanup rough list
        foreach( $tmpDependencyList as $className => $classDependencyList )
        {
            $tmpDependencyList[$className] = array_unique( $classDependencyList );
            foreach( $tmpDependencyList[$className] as $key => $value )
            {
                if ( !in_array( $value, array_keys( $tmpDependencyList ) ) )
                {
                    unset( $tmpDependencyList[$className][$key] );
                }
                if ( $className == $value )
                {
                    unset( $tmpDependencyList[$className][$key] );
                }
            }
        }

        $dependencyList = array();
        // Build complete list
        for ( $i = 0 ; $i <= count( $tmpDependencyList ); $i++ )
        {
            $classList2 = array();
            foreach( $tmpDependencyList as $className => $classDependencyList )
            {
                if ( empty( $classDependencyList ) )
                {
                    $classList2[] = $className;
                }
            }

            foreach( $classList2 as $className )
            {
                unset( $tmpDependencyList[$className] );
            }

            foreach( $tmpDependencyList as $className => $classDependencyList )
            {
                foreach( $classDependencyList as $innerKey => $innerValue )
                {
                    if ( in_array( $innerValue, $classList2 ) )
                    {
                        unset( $tmpDependencyList[$className][$innerKey] );
                    }
                }
            }

            $dependencyList = array_merge( $dependencyList, $classList2 );
        }

        // Append list of failed dependencies
        foreach( $tmpDependencyList as $className => $value )
        {
            $dependencyList[] = $className;
        }

        foreach( $dependencyList as $key => $className )
        {
            if ( !in_array( $className, $classList ) )
            {
                unset( $dependencyList[$key] );
            }
        }

        return $dependencyList;
    }
}

?>
