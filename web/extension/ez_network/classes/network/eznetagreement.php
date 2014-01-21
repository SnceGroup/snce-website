<?php
/**
 * File containing eZNetAgreementDEPRECATED class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetAgreement eznetagreement.php
  \brief The class eZNetAgreement does

*/
class eZNetAgreementDEPRECATED extends eZPersistentObject
{
    // Consts
    const LevelAccessToPatch = 300;
    const LevelSupport = 250;
    const LevelInternalTesting = 200;
    const LevelStarter = 125;
    const LevelOnDemandStarter = 115;
    const LevelOnDemandPlus =    110;
    const LevelBasic =   100;
    const LevelSilver =   75;
    const LevelGold =     50;
    const LevelPlatinum = 25;
    const LevelNow      = 20;
    const LevelNowPlus  = 18;
    const LevelPremiumBasic =  17;
    const LevelPremiumSilver = 16;
    const LevelPremiumGold = 14;
    const LevelPremiumPlatinum = 12;

    const IsDeprecatedFalse = 0;
    const IsDeprecatedTrue = 1;

    const IsEnabledFalse = 0;
    const IsEnabledTrue = 1;

    const ContentClassID = 52;


    /*!
     Constructor
    */
    function eZNetAgreement( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }

    /*!
     \reimp
    */
    static function definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => false,
                                                        'foreign_override_class' => 'eZContentObject',
                                                        'foreign_override_attribute' => 'id' ),
                                         "name" => array( 'name' => 'Name',
                                                          'datatype' => 'string',
                                                          'default' => '',
                                                          'required' => true ),
                                         "description" => array( 'name' => 'Description',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true ),
                                         "email" => array( 'name' => 'Email',
                                                           'datatype' => 'string',
                                                           'default' => '',
                                                           'required' => true ),
                                         "identifier" => array( 'name' => 'Identifier',
                                                                'datatype' => 'string',
                                                                'default' => '',
                                                                'required' => true ),
                                         "initial_response_time" => array( 'name' => 'Initial response time',
                                                                           'datatype' => 'integer',
                                                                           'default' => 0,
                                                                           'required' => true ),
                                         "is_deprecated" => array( 'name' => 'Is deprecated',
                                                                   'datatype' => 'integer',
                                                                   'default' => 0,
                                                                   'required' => true ),
                                         "is_enabled" => array( 'name' => 'Is enabled',
                                                                   'datatype' => 'integer',
                                                                   'default' => 1,
                                                                   'required' => true ),
                                         "modified" => array( 'name' => 'Modified',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ),
                                         ),
                      "keys" => array( 'id' ),
                      "function_attributes" => array(),
                      "increment_key" => "id",
                      "class_name" => "eZNetAgreement",
                      'soap_custom_handler' => true,
                      "sort" => array( "Name" => "asc" ),
                      "name" => "ezx_ezpnet_agreement" );
    }

    /*!
     \static
    */
    static function fetch( $id,
                           $isDeprecated = eZNetAgreement::IsDeprecatedFalse,
                           $isEnabled = eZNetAgreement::IsEnabledTrue,
                           $asObject = true )
    {
        return eZPersistentObject::fetchObject( eZNetAgreement::definition(),
                                                null,
                                                array( 'id' => $id,
                                                       'is_deprecated' => $isDeprecated,
                                                       'is_enabled' => $isEnabled ),
                                                $asObject );
    }

    /*!
     \static

     Fetch list of Network Agreements.

    */
    static function fetchList( $offset = 0,
                               $limit = 100,
                               $isDeprecated = eZNetAgreement::IsDeprecatedFalse,
                               $isEnabled = eZNetAgreement::IsEnabledTrue,
                               $asObject = true )
    {
        $condArray = array( 'is_deprecated' => eZNetAgreement::IsDeprecatedFalse,
                            'is_enabled' => eZNetAgreement::IsEnabledTrue );

        return eZPersistentObject::fetchObjectList( eZNetAgreement::definition(),
                                                    null,
                                                    $condArray,
                                                    array( 'id' => 'desc' ),
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject );
    }

    /*!
     \static

     Get specification for custom datamapping. ( to use with SOAP sync. )

     Syntax :
     array( <attribute> => array( <function 1> => array( <function1 param1>, <function 1 param2>, ...), <function 2> => array( ... ) )| <index>, )
     */
    static function customDataMapDefinition()
    {
        return array( 'fields' => array( 'id' => array( 'attribute' => array( 'id' ) ),
                                         'name' => array( 'dataMap' => array(),
                                                          'name',
                                                          'attribute' => array( 'data_text' ) ),
                                         'description' => array( 'dataMap' => array(),
                                                                 'description',
                                                                 'attribute' => array( 'data_text' ) ),
                                         'email' => array( 'dataMap' => array(),
                                                           'email',
                                                           'attribute' => array( 'data_text' ) ),
                                         'identifier' => array( 'dataMap' => array(),
                                                                'identifier',
                                                                'attribute' => array( 'data_text' ) ),
                                         'initial_response_time' => array( 'dataMap' => array(),
                                                                           'initial_response_time',
                                                                           'attribute' => array( 'data_int' ) ),
                                         'is_deprecated' => array( 'dataMap' => array(),
                                                                   'is_deprecated',
                                                                   'attribute' => array( 'data_int' ) ),
                                         'is_enabled' => array( 'dataMap' => array(),
                                                                'is_enabled',
                                                                'attribute' => array( 'data_int' ) ),
                                         'modified' => array( 'attribute' => array( 'modified' ) ),
                                         ) );
    }

    /*!
     \static
     Get key name

     \return key name
    */
    static function customKeyName()
    {
        return 'id';
    }

    /*!
     \static
     Get custom max from current class. \sa eZNetSOAPSync::getCustomMax()

     \return max id for the eZCRMCustomer data.
    */
    static function getCustomMax()
    {
        $resultSet = eZContentObject::fetchObjectList( eZContentObject::definition(),
                                                       array(),
                                                       array( 'contentclass_id' => eZNetAgreement::ContentClassID,
                                                              'status' => eZContentObject::STATUS_PUBLISHED ),
                                                       null,
                                                       null,
                                                       false,
                                                       false,
                                                       array( array( 'operation' => 'max( id )',
                                                                     'name' => 'max' ) ) );
        return isset( $resultSet[0]['max'] ) ? $resultSet[0]['max'] : false;
    }

    /*!
     \static
     Get custom data fetch definition
    */
    static function customDataFetchDefinition()
    {
        $db = eZDB::instance();
        $result = $db->arrayQuery( 'SELECT MAX( remote_modified ) as max_modified
                                    FROM ezx_ezpnet_soap_log
                                    WHERE class_name=\'eZNetAgreement\'' );

        $maxModified = 0;
        if ( $result &&
             count( $result ) == 1 )
        {
            $maxModified = $result[0]['max_modified'];
        }
        return array( 'class_name' => 'eZContentObject',
                      'conditions' => array( 'contentclass_id' => eZNetAgreement::ContentClassID,
                                             'status' => eZContentObject::STATUS_PUBLISHED,
                                             'modified' => array( '>', $maxModified ) ),
                      'include_file' => 'kernel/classes/ezcontentobject.php' );
    }

    /*!
     \static
     Get custom data filter from for sync log.
    */
    static function customDataFilter()
    {
        return 'eZNetAgreement';
    }

    /*!
     Get latest ID ( soap custom handler )

     \param remote host
    */
    static function getLatestID( $remoteHost )
    {
        return false;
    }

    /*!
     \static

     Get Agreement ranking list. Agreement identifier as array key

     Lowest number is highest priority
    */
    static function agreementPriorityList()
    {
        return array( 'access_to_patch' => eZNetAgreement::LevelAccessToPatch,
                      'support' => eZNetAgreement::LevelSupport,
                      'internal_testing' => eZNetAgreement::LevelInternalTesting,
                      'starter' => eZNetAgreement::LevelStarter,
                      'on_demand_starter' => eZNetAgreement::LevelOnDemandStarter,
                      'on_demand_plus' => eZNetAgreement::LevelOnDemandPlus,
                      'basic' => eZNetAgreement::LevelBasic,
                      'silver' => eZNetAgreement::LevelSilver,
                      'gold' => eZNetAgreement::LevelGold,
                      'platinum' => eZNetAgreement::LevelPlatinum,
                      'now' => eZNetAgreement::LevelNow,
                      'now_plus' => eZNetAgreement::LevelNowPlus,
                      'premium_basic' => eZNetAgreement::LevelPremiumBasic,
                      'premium_silver' => eZNetAgreement::LevelPremiumSilver,
                      'premium_gold' => eZNetAgreement::LevelPremiumGold,
                      'premium_platinum' => eZNetAgreement::LevelPremiumPlatinum );
    }

    /*!
     \static
     Get agreements which should have network issue trackers.

     \return array of agreement identifiers
    */
    static function issueAgreementIdentifierList()
    {
        return array( 'access_to_patch',
                      'support',
                      'internal_testing',
                      'on_demand_starter',
                      'on_demand_plus',
                      'basic',
                      'silver',
                      'gold',
                      'platinum',
                      'now',
                      'now_plus',
                      'premium_basic',
                      'premium_silver',
                      'premium_gold',
                      'premium_platinum' );
    }
}

?>
