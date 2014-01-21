<?php
/**
 * File containing eZNetInstallationAgreement class
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0
 * @version 5.2.0
 * @package ez_network
 */

/*!
  \class eZNetInstallationAgreement eznetinstallationagreement.php
  \brief Agreement - installation list

*/
class eZNetInstallationAgreement extends eZPersistentObject
{
    /*!
     Constructor
    */
    function eZNetInstallationAgreement( $row = array() )
    {
        $this->eZPersistentObject( $row );
    }

    static function definition()
    {
        return array( "fields" => array( "id" => array( 'name' => 'ID',
                                                        'datatype' => 'integer',
                                                        'default' => 0,
                                                        'required' => true ),
                                         "status" => array( 'name' => 'Status',
                                                            'datatype' => 'integer',
                                                            'default' => 0,
                                                            'required' => true,
                                                            'keep_key' => true ),
                                         "installation_id" => array( 'name' => 'eZNetInstallationID',
                                                                     'datatype' => 'integer',
                                                                     'default' => 0,
                                                                     'required' => true,
                                                                     'foreign_class' => 'eZNetInstallation',
                                                                     'foreign_attribute' => 'id',
                                                                     'multiplicity' => '1..*' ),
                                         "agreement_id" => array( 'name' => 'AgreementID',
                                                                  'datatype' => 'integer',
                                                                  'default' => 0,
                                                                  'required' => true,
                                                                  'foreign_override_class' => 'eZContentObject',
                                                                  'foreign_override_attribute' => 'id',
                                                                  'multiplicity' => '1..*' ),
                                         'created' => array( 'name' => 'Created',
                                                             'datatype' => 'integer',
                                                             'default' => 0,
                                                             'required' => true ),
                                         'creator_id' => array( 'name' => 'CreatorID',
                                                                'datatype' => 'integer',
                                                                'default' => 0,
                                                                'required' => true ),
                                         'modified' => array( 'name' => 'Modified',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ),
                                         "description" => array( 'name' => 'Description',
                                                                 'datatype' => 'string',
                                                                 'default' => '',
                                                                 'required' => true ),
                                         "comment" => array( 'name' => 'Comment',
                                                             'datatype' => 'string',
                                                             'default' => '',
                                                             'required' => true ),
                                         'start_ts' => array( 'name' => 'StartTS',
                                                              'datatype' => 'integer',
                                                              'default' => 0,
                                                              'required' => true ),
                                         'end_ts' => array( 'name' => 'EndTS',
                                                            'datatype' => 'integer',
                                                            'default' => 0,
                                                            'required' => true ),
                                         'options' => array( 'name' => 'Options',
                                                             'datatype' => 'string',
                                                             'default' => '',
                                                             'required' => true ),
                                         ),
                      "keys" => array( "id", 'status' ),
                      "function_attributes" => array( 'creator' => 'creator',
                                                      'installation' => 'installation',
                                                      'agreement' => 'agreement',
                                                      'start_date_time' => 'startDateTime',
                                                      'end_date_time' => 'endDateTime',
                                                      'option_array' => 'optionArray',
                                                      ),
                      "increment_key" => "id",
                      "class_name" => "eZNetInstallationAgreement",
                      "sort" => array( "description" => "asc" ),
                      "name" => "ezx_ezpnet_inst_agreement" );
    }

    /*!
    \reimp
    */
    function attribute( $attr, $noFunction = false )
    {
        $retVal = null;
        switch( $attr )
        {
            case 'start_date_time':
            case 'end_date_time':
            {
                $map = array( 'start_date_time' => 'start_ts',
                              'end_date_time' => 'end_ts' );
                $retVal = new eZDateTime( $this->attribute( $map[$attr] ) );
            } break;

            case 'agreement':
            {
                $retVal = eZContentObject::fetch( $this->attribute( 'agreement_id' ) );
            } break;

            case 'installation':
            {
                $retVal = eZNetInstallation::fetch( $this->attribute( 'installation_id' ) );
            } break;

            case 'creator':
            {
                $retVal = eZUser::fetch( $this->attribute( 'creator_id' ) );
            } break;

            case 'option_array':
            {
                $optionDef = $this->attribute( 'options' );
                $retVal = $optionDef == '' ? array() : unserialize( $optionDef );
            } break;

            default:
            {
                $retVal = eZPersistentObject::attribute( $attr );
            } break;
        }

        return $retVal;
    }

    /*!
     \static

     \param installation ID

     Get total agreement count
    */
    static function countByInstallationID( $installationID = false,
                                           $status = eZNetInstallationAgreement::STAUS_PUBLISHED )
    {
        $condArray = array( 'status' => $status );
        if ( $installationID )
        {
            $condArray['installation_id'] = $installationID;
        }

        $resultSet = eZPersistentObject::fetchObjectList( eZNetInstallationAgreement::definition(),
                                                          array(),
                                                          $condArray,
                                                          null,
                                                          null,
                                                          false,
                                                          false,
                                                          array( array( 'operation' => 'count(id)',
                                                                        'name' => 'count' ) ) );
        return $resultSet[0]['count'];
    }

    /*!
     \static

     Create new patch item
    */
    static function create( $installationID,
                            $agreementID )
    {
        $startTS = time();
        $endDateTime = new eZDateTime( $startTS );
        $endDateTime->setYear( $endDateTime->year() + 1 );

        return new eZNetInstallationAgreement( array( 'status' => eZNetInstallationAgreement::STAUS_DRAFT,
                                                      'start_ts' => $startTS,
                                                      'end_ts' => $endDateTime->timeStamp(),
                                                      'installation_id' => $installationID,
                                                      'agreement_id' => $agreementID,
                                                      'created' => time(),
                                                      'creator_id' => eZUser::currentUserID() ) );
    }

    /*!
     \reimp
    */
    static function fetch( $id,
                           $status = eZNetInstallationAgreement::STAUS_PUBLISHED,
                           $asObject = true )
    {
        return eZPersistentObject::fetchObject( eZNetInstallationAgreement::definition(),
                                                null,
                                                array( 'id' => $id,
                                                       'status' => $status ),
                                                $asObject );
    }

    /*!
     \static

     Fetch draft list. If no draft exist, create draft from existing published object

     \param installation ID
    */
    static function fetchDraftList( $installationID,
                                    $asObject = true )
    {
        $draftList = eZNetInstallationAgreement::fetchList( $installationID,
                                                            0,
                                                            100,
                                                            eZNetInstallationAgreement::STAUS_DRAFT );
        $publishList = eZNetInstallationAgreement::fetchList( $installationID,
                                                              0,
                                                              100,
                                                              eZNetInstallationAgreement::STAUS_PUBLISHED );
        $draftIDList = array();
        foreach( $draftList as $draft )
        {
            $draftIDList[] = $draft->attribute( 'id' );
        }

        // Create draft from published item, if draft does not exist. Ignore if draft already exists.
        foreach( $publishList as $published )
        {
            if ( !in_array( $published->attribute( 'id' ), $draftIDList ) )
            {
                $draftList[] = eZNetInstallationAgreement::fetchDraft( $published->attribute( 'id' ) );
            }
        }

        return $draftList;
    }

    /*!
     \static

     Fetch draft. If no draft exist, create draft from existing published object
    */
    static function fetchDraft( $id,
                                $force = true,
                                $asObject = true )
    {
        $draft = eZNetInstallationAgreement::fetch( $id,
                                                    eZNetInstallationAgreement::STAUS_DRAFT,
                                                    $asObject );
        if ( !$draft &&
             $force )
        {
            $draft = eZNetInstallationAgreement::fetch( $id,
                                                        eZNetInstallationAgreement::STAUS_PUBLISHED,
                                                        $asObject );

            if ( $draft )
            {
                $draft->setAttribute( 'status', eZNetInstallationAgreement::STAUS_DRAFT );
                $draft->sync();
            }
        }

        return $draft;
    }

    /*!
     Publish current object
    */
    function publish()
    {
        $this->setAttribute( 'status', eZNetInstallationAgreement::STAUS_PUBLISHED );
        $this->setAttribute( 'modified', time() );
        $this->store();
        $this->removeDraft();
    }

    /*!
     Remove draft.
    */
    function removeDraft()
    {
        $draft = eZNetInstallationAgreement::fetchDraft( $this->attribute( 'id' ),
                                                         false );
        if ( $draft )
        {
            $draft->remove();
        }
    }

    /*!
     \static

     Fetch list of Network installations.

     \param Customer ID
    */
    static function fetchList( $installationID = false,
                        $offset = 0,
                        $limit = 100,
                        $status = eZNetInstallationAgreement::STAUS_PUBLISHED,
                        $additionalConditions = array(),
                        $asObject = true )
    {
        $condArray = array( 'status' => $status );
        if ( $installationID !== false )
        {
            $condArray['installation_id'] = $installationID;
        }

        $condArray = array_merge( $condArray, $additionalConditions );

        return eZPersistentObject::fetchObjectList( eZNetInstallationAgreement::definition(),
                                                    null,
                                                    $condArray,
                                                    array( 'id' => 'desc' ),
                                                    array( 'limit' => $limit,
                                                           'offset' => $offset ),
                                                    $asObject );
    }

    /*!
     \static

     Remove Agreement link object

     \param Agreement ID
    */
    static function removeAgreement( $agreementID )
    {
        eZNetInstallationAgreement::removeObject( eZNetInstallationAgreement::definition(),
                                                  array( 'id' => $agreementID ) );
    }

    /*!
     Set option

     \param option name
     \param option value
    */
    function setOption( $attr, $value )
    {
        $optionArray = $this->attribute( 'option_array' );
        $optionArray[$attr] = $value;
        $this->setAttribute( 'options', serialize( $optionArray ) );
    }

    /*!
     Check if option is set.

     \param option name
    */
    function hasOption( $attr )
    {
        $optionArray = $this->attribute( 'option_array' );
        return isset( $optionArray[$attr] );
    }

    /*
     Get option

     \param option name

     \return option value
    */
    function option( $attr )
    {
        $optionArray = $this->attribute( 'option_array' );
        return isset( $optionArray[$attr] ) ? $optionArray[$attr] : false;
    }

    /// Constants
    const STAUS_DRAFT = 0;
    const STAUS_PUBLISHED = 1;
}

?>
