<?php
/**
 * File containing the eZNetModuleBranchDependency class.
 *
 * @copyright Copyright (C) 1999-2013 eZ Systems AS. All rights reserved.
 * @license http://ez.no/software/proprietary_license_options/ez_proprietary_use_license_v1_0 PUL
 * @version 5.2.0
 * @package ez_network
 */

/**
 * Class: eZNetModuleBranchDependency
 */
class eZNetModuleBranchDependency extends eZPersistentObject
{
    public static function definition()
    {
        return array(
            'fields' => array(
                'module_branch_id' => array(
                    'name' => 'moduleBranchID',
                    'datatype' => 'integer',
                    'default' => 0,
                    'required' => true
                ),
                'depends_on_module_branch_id' => array(
                    'name' => 'dependsOnModuleBranchID',
                    'datatype' => 'integer',
                    'default' => 0,
                    'required' => true
                )
            ),
            'keys' => array( 'module_branch_id', 'depends_on_module_branch_id' ),
            'function_attributes' => array(
                'module' => 'fetchModule',
                'dependency' => 'fetchDependency'
            ),
            'class_name' => 'eZNetModuleBranchDependency',
            'sort' => array( 'module_branch_id' => 'asc' ),
            'name' => 'ezx_ezpnet_module_branch_deps' );
    }

    /**
     * Module branch the dependency originates from
     *
     * @return eZNetModuleBranch
     */
    public function fetchModule()
    {
        if ( $this->moduleBranchID !== null )
            return eZNetModuleBranch::fetch( $this->moduleBranchID );
    }

    /**
     * Module branch the dependency is targeted at
     *
     * @return eZNetModuleBranch
     */
    function fetchDependency()
    {
        if ( $this->dependsOnModuleBranchID !== null )
            return eZNetModuleBranch::fetch( $this->dependsOnModuleBranchID );
    }

    /**
     * Fetches the list of a module's dependencies
     * @param eZNetModuleBranch $module
     * @return array(eZNetModuleBranchDependency)
     */
    public static function fetchDependsModulesList( eZNetModuleBranch $module, $asObject = true )
    {
        return eZPersistentObject::fetchObjectList(
            self::definition(),
            null,
            array( 'module_branch_id' => $module->attribute( 'id' ) ),
            null, null,
            $asObject
        );
    }

    /**
     * Fetches the list of dependencies for a given module branch
     *
     * @param eZNetModuleBranch $module
     * @return array( eZNetModuleBranch )
     */
    public static function fetchUncertifiedDependencies( eZNetModuleBranch $module )
    {
        $netModuleBranchDef = eZNetModuleBranch::definition();
        $netModuleBranchDepsDef = eZNetModuleBranchDependency::definition();
        $joins =
            " AND {$netModuleBranchDef['name']}.id = {$netModuleBranchDepsDef['name']}.depends_on_module_branch_id" .
            " AND {$netModuleBranchDef['name']}.status = " . eZNetModuleBranch::StatusPublished .
            " AND {$netModuleBranchDef['name']}.is_certified = 0";
        return eZNetModuleBranchDependency::fetchObjectList(
            eZNetModuleBranchDependency::definition(),
            null,
            array( 'module_branch_id' => $module->attribute( 'id' ) ),
            null, null, true, null, null,
            array( $netModuleBranchDef['name'] ),
            $joins
        );
    }

    /**
     * Sets the list of a module dependencies
     *
     * @param eZNeModuleBranch $module
     * @param array(eZNetModuleBranch::ID) $moduleBranchIDArray
     * @return void
     */
    public static function setDependencies( eZNetModuleBranch $module, $moduleBranchIDArray )
    {
        $db = eZDB::instance();

        $db->begin();

        // delete all known dependencies
        eZPersistentObject::removeObject(
            eZNetModuleBranchDependency::definition(),
            array( 'module_branch_id' => $module->attribute( 'id' ) )
        );


        // (re)create the given ones
        foreach ( $moduleBranchIDArray as $dependencyID )
        {
            $row = array(
                'module_branch_id' => $module->attribute( 'id' ),
                'depends_on_module_branch_id' => $dependencyID,
            );
            $po = new eZNetModuleBranchDependency( $row );
            $po->store();
            unset( $po );
        }

        $db->commit();
    }

    public $moduleBranchID = null;
    public $dependsOnModuleBranchID = null;
}

?>
