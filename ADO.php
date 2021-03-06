<?php
namespace Sigmalab\Database;

/******************************************************************************
 Copyright (c) 2005-2022 by Alexei V. Vasilyev.  All Rights Reserved.
 -----------------------------------------------------------------------------
 Module     : ADO - Abstract Data Objects
 File       : ADO.php
 Author     : Alexei V. Vasilyev
******************************************************************************/

  /**
   
  \defgroup ado Abstract data objects architecture
  @{
  
  \defgroup ado_basic       Basic classes
  \defgroup ado_datasource  Data Sources
  \defgroup ado_objects     Generated Data objects
  \defgroup ado_relations   Data Relations
  \defgroup ado_statements  SQL Statements
  \defgroup ado_obsolete    Obsolete classes
  */

  /*  @} */


  /** \addtogroup ado_basic

  Section describes classes which have used in basic ADO architecture

  Abstract data objects for TEMIS subsystem provides complex service 
  for constructing platform intepended SQL queries and executing its.
 
  ADO contains only two leayes:

  High, applicaion layer provides strutured SQL for building queries.
  \see ado_statements

  Low, common data base level provides  services for working with database engines.
  \see ado_datasource 
  \see ado_objects
  \see ado_relations

  */

  /** \addtogroup ado_datasource

  Section describes classes concern to creating and using \b Data \b Source objects.
  */

  /** \addtogroup ado_relations

  Section describes object data relations features.
   */

  /** \addtogroup ado_statements

  Section describes how to create SQL object statements without using SQL code.
  
   */

  /** \addtogroup ado_obsolete

  Section desribes obsolete classs which need avoid using in your new programs
  */
if( !defined( "__ADO_PHP_DIR__" ) ) define(  "__ADO_PHP_DIR__", __DIR__. '/' );

require_once __ADO_PHP_DIR__. 'autoload.php';

require_once( __ADO_PHP_DIR__  . "package.deps.php" );
require_once __ADO_PHP_DIR__ .  'StmHelper.php';

//required VKCOM
require_once __DIR__.'/../vendor/autoload.php';

