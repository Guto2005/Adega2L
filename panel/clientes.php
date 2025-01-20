<?php
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                                   ATTENTION!
 * If you see this message in your browser (Internet Explorer, Mozilla Firefox, Google Chrome, etc.)
 * this means that PHP is not properly installed on your web server. Please refer to the PHP manual
 * for more details: http://php.net/manual/install.php 
 *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 */

    include_once dirname(__FILE__) . '/components/startup.php';
    include_once dirname(__FILE__) . '/components/application.php';
    include_once dirname(__FILE__) . '/' . 'authorization.php';


    include_once dirname(__FILE__) . '/' . 'database_engine/mysql_engine.php';
    include_once dirname(__FILE__) . '/' . 'components/page/page_includes.php';

    function GetConnectionOptions()
    {
        $result = GetGlobalConnectionOptions();
        $result['client_encoding'] = 'utf8';
        GetApplication()->GetUserAuthentication()->applyIdentityToConnectionOptions($result);
        return $result;
    }

    
    
    class clientes_cli_cidadeModalViewPage extends ViewBasedPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cidades`');
            $this->dataset->addFields(
                array(
                    new IntegerField('cidade_id', true, true, true),
                    new StringField('cidade_nome', true)
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for cidade_id field
            //
            $column = new NumberViewColumn('cidade_id', 'cidade_id', 'Cidade Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cidade_nome field
            //
            $column = new TextViewColumn('cidade_nome', 'cidade_nome', 'Cidade Nome', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            
            
        }
    
        static public function getHandlerName() {
            return get_class() . '_modal_view';
        }
    
        public function GetModalGridViewHandler() {
            return self::getHandlerName();
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    }
    
    class clientes_cli_bairroModalViewPage extends ViewBasedPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bairros`');
            $this->dataset->addFields(
                array(
                    new IntegerField('bairro_id', true, true, true),
                    new StringField('bairro_nome'),
                    new IntegerField('bairro_cidade', true)
                )
            );
            $this->dataset->AddLookupField('bairro_cidade', 'cidades', new IntegerField('cidade_id'), new StringField('cidade_nome', false, false, false, false, 'bairro_cidade_cidade_nome', 'bairro_cidade_cidade_nome_cidades'), 'bairro_cidade_cidade_nome_cidades');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for bairro_id field
            //
            $column = new NumberViewColumn('bairro_id', 'bairro_id', 'Bairro Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for bairro_nome field
            //
            $column = new TextViewColumn('bairro_nome', 'bairro_nome', 'Bairro Nome', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cidade_nome field
            //
            $column = new TextViewColumn('bairro_cidade', 'bairro_cidade_cidade_nome', 'Bairro Cidade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            
            
        }
    
        static public function getHandlerName() {
            return get_class() . '_modal_view';
        }
    
        public function GetModalGridViewHandler() {
            return self::getHandlerName();
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    }
    
    class clientes_cli_bairro_level1NestedPage extends NestedFormPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bairros`');
            $this->dataset->addFields(
                array(
                    new IntegerField('bairro_id', true, true, true),
                    new StringField('bairro_nome'),
                    new IntegerField('bairro_cidade', true)
                )
            );
            $this->dataset->AddLookupField('bairro_cidade', 'cidades', new IntegerField('cidade_id'), new StringField('cidade_nome', false, false, false, false, 'bairro_cidade_cidade_nome', 'bairro_cidade_cidade_nome_cidades'), 'bairro_cidade_cidade_nome_cidades');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for bairro_nome field
            //
            $editor = new TextEdit('bairro_nome_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Bairro Nome', 'bairro_nome', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for bairro_cidade field
            //
            $editor = new DynamicCombobox('bairro_cidade_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cidades`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('cidade_id', true, true, true),
                    new StringField('cidade_nome', true)
                )
            );
            $lookupDataset->setOrderByField('cidade_nome', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Bairro Cidade', 'bairro_cidade', 'bairro_cidade_cidade_nome', 'insert_clientes_cli_bairro_level1NestedPage_bairro_cidade_search', $editor, $this->dataset, $lookupDataset, 'cidade_id', 'cidade_nome', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
            $column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
       static public function getNestedInsertHandlerName()
        {
            return get_class() . '_form_insert';
        }
    
        public function GetGridInsertHandler()
        {
            return self::getNestedInsertHandlerName();
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        public function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
    }
    
    // OnBeforePageExecute event handler
    
    
    
    class clientesPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Clientes');
            $this->SetMenuLabel('Clientes');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`clientes`');
            $this->dataset->addFields(
                array(
                    new IntegerField('cli_id', true, true, true),
                    new StringField('cli_nome'),
                    new StringField('cli_telefone'),
                    new StringField('cli_end'),
                    new IntegerField('cli_bairro', true),
                    new IntegerField('cli_cidade', true)
                )
            );
            $this->dataset->AddLookupField('cli_cidade', 'cidades', new IntegerField('cidade_id'), new StringField('cidade_nome', false, false, false, false, 'cli_cidade_cidade_nome', 'cli_cidade_cidade_nome_cidades'), 'cli_cidade_cidade_nome_cidades');
            $this->dataset->AddLookupField('cli_bairro', 'bairros', new IntegerField('bairro_id'), new StringField('bairro_nome', false, false, false, false, 'cli_bairro_bairro_nome', 'cli_bairro_bairro_nome_bairros'), 'cli_bairro_bairro_nome_bairros');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function CreatePageNavigator()
        {
            $result = new CompositePageNavigator($this);
            
            $partitionNavigator = new PageNavigator('pnav', $this, $this->dataset);
            $partitionNavigator->SetRowsPerPage(20);
            $result->AddPageNavigator($partitionNavigator);
            
            return $result;
        }
    
        protected function CreateRssGenerator()
        {
            return null;
        }
    
        protected function setupCharts()
        {
    
        }
    
        protected function getFiltersColumns()
        {
            return array(
                new FilterColumn($this->dataset, 'cli_id', 'cli_id', 'Cli Id'),
                new FilterColumn($this->dataset, 'cli_nome', 'cli_nome', 'Cliente'),
                new FilterColumn($this->dataset, 'cli_end', 'cli_end', 'Endereco'),
                new FilterColumn($this->dataset, 'cli_telefone', 'cli_telefone', 'Telefone'),
                new FilterColumn($this->dataset, 'cli_cidade', 'cli_cidade_cidade_nome', 'Cidade'),
                new FilterColumn($this->dataset, 'cli_bairro', 'cli_bairro_bairro_nome', 'Bairro')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['cli_nome'])
                ->addColumn($columns['cli_end'])
                ->addColumn($columns['cli_telefone'])
                ->addColumn($columns['cli_cidade'])
                ->addColumn($columns['cli_bairro']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('cli_cidade')
                ->setOptionsFor('cli_bairro');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('View'), OPERATION_VIEW, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Edit'), OPERATION_EDIT, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowEditButtonHandler', $this);
            }
            
            if ($this->deleteOperationIsAllowed()) {
                $operation = new AjaxOperation(OPERATION_DELETE,
                    $this->GetLocalizerCaptions()->GetMessageString('Delete'),
                    $this->GetLocalizerCaptions()->GetMessageString('Delete'), $this->dataset,
                    $this->GetModalGridDeleteHandler(), $grid
                );
                $operation->setUseImage(true);
                $actions->addOperation($operation);
                $operation->OnShow->AddListener('ShowDeleteButtonHandler', $this);
            }
            
            
            if ($this->GetSecurityInfo()->HasAddGrant())
            {
                $operation = new LinkOperation($this->GetLocalizerCaptions()->GetMessageString('Copy'), OPERATION_COPY, $this->dataset, $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for cli_nome field
            //
            $column = new TextViewColumn('cli_nome', 'cli_nome', 'Cliente', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for cli_end field
            //
            $column = new TextViewColumn('cli_end', 'cli_end', 'Endereco', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for cli_telefone field
            //
            $column = new TextViewColumn('cli_telefone', 'cli_telefone', 'Telefone', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for cidade_nome field
            //
            $column = new TextViewColumn('cli_cidade', 'cli_cidade_cidade_nome', 'Cidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(clientes_cli_cidadeModalViewPage::getHandlerName());
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for bairro_nome field
            //
            $column = new TextViewColumn('cli_bairro', 'cli_bairro_bairro_nome', 'Bairro', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(clientes_cli_bairroModalViewPage::getHandlerName());
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
    
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for cli_nome field
            //
            $editor = new TextEdit('cli_nome_edit');
            $editor->SetMaxLength(90);
            $editColumn = new CustomEditColumn('Cliente', 'cli_nome', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cli_end field
            //
            $editor = new TextEdit('cli_end_edit');
            $editor->SetMaxLength(80);
            $editColumn = new CustomEditColumn('Endereco', 'cli_end', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cli_telefone field
            //
            $editor = new TextEdit('cli_telefone_edit');
            $editor->SetMaxLength(15);
            $editColumn = new CustomEditColumn('Telefone', 'cli_telefone', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cli_bairro field
            //
            $editor = new CascadingCombobox('cli_bairro_edit', $this->CreateLinkBuilder());
            
            $dataset0 = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cidades`');
            $dataset0->addFields(
                array(
                    new IntegerField('cidade_id', true, true, true),
                    new StringField('cidade_nome', true)
                )
            );
            $dataset0->setOrderByField('cidade_nome', 'ASC');
            GetApplication()->RegisterHTTPHandler($editor->createHttpHandler($dataset0, 'cidade_id', 'cidade_nome', null, ArrayWrapper::createGetWrapper()));
            $level = $editor->addLevel($dataset0, 'cidade_id', 'cidade_nome', 'Cidade', null);
            
            $dataset1 = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bairros`');
            $dataset1->addFields(
                array(
                    new IntegerField('bairro_id', true, true, true),
                    new StringField('bairro_nome'),
                    new IntegerField('bairro_cidade', true)
                )
            );
            $dataset1->setOrderByField('bairro_nome', 'ASC');
            GetApplication()->RegisterHTTPHandler($editor->createHttpHandler($dataset1, 'bairro_id', 'bairro_nome', new ForeignKeyInfo('cidade_id', 'bairro_cidade'), ArrayWrapper::createGetWrapper()));
            $level = $editor->addLevel($dataset1, 'bairro_id', 'bairro_nome', 'Bairro', new ForeignKeyInfo('cidade_id', 'bairro_cidade'));
            $level->setNestedInsertFormLink(
                $this->GetHandlerLink(clientes_cli_bairro_level1NestedPage::getNestedInsertHandlerName())
            );
            
            $editColumn = new CascadingEditColumn('Bairro', 'cli_bairro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
    
        }
    
        protected function AddToggleEditColumns(Grid $grid)
        {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for cli_nome field
            //
            $editor = new TextEdit('cli_nome_edit');
            $editor->SetMaxLength(90);
            $editColumn = new CustomEditColumn('Cliente', 'cli_nome', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cli_end field
            //
            $editor = new TextEdit('cli_end_edit');
            $editor->SetMaxLength(80);
            $editColumn = new CustomEditColumn('Endereco', 'cli_end', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cli_telefone field
            //
            $editor = new TextEdit('cli_telefone_edit');
            $editor->SetMaxLength(15);
            $editColumn = new CustomEditColumn('Telefone', 'cli_telefone', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cli_bairro field
            //
            $editor = new CascadingCombobox('cli_bairro_edit', $this->CreateLinkBuilder());
            
            $dataset0 = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cidades`');
            $dataset0->addFields(
                array(
                    new IntegerField('cidade_id', true, true, true),
                    new StringField('cidade_nome', true)
                )
            );
            $dataset0->setOrderByField('cidade_nome', 'ASC');
            GetApplication()->RegisterHTTPHandler($editor->createHttpHandler($dataset0, 'cidade_id', 'cidade_nome', null, ArrayWrapper::createGetWrapper()));
            $level = $editor->addLevel($dataset0, 'cidade_id', 'cidade_nome', 'Cidade', null);
            
            $dataset1 = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bairros`');
            $dataset1->addFields(
                array(
                    new IntegerField('bairro_id', true, true, true),
                    new StringField('bairro_nome'),
                    new IntegerField('bairro_cidade', true)
                )
            );
            $dataset1->setOrderByField('bairro_nome', 'ASC');
            GetApplication()->RegisterHTTPHandler($editor->createHttpHandler($dataset1, 'bairro_id', 'bairro_nome', new ForeignKeyInfo('cidade_id', 'bairro_cidade'), ArrayWrapper::createGetWrapper()));
            $level = $editor->addLevel($dataset1, 'bairro_id', 'bairro_nome', 'Bairro', new ForeignKeyInfo('cidade_id', 'bairro_cidade'));
            $level->setNestedInsertFormLink(
                $this->GetHandlerLink(clientes_cli_bairro_level1NestedPage::getNestedInsertHandlerName())
            );
            
            $editColumn = new CascadingEditColumn('Bairro', 'cli_bairro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            $grid->SetShowAddButton(true && $this->GetSecurityInfo()->HasAddGrant());
        }
    
        private function AddMultiUploadColumn(Grid $grid)
        {
    
        }
    
        protected function AddPrintColumns(Grid $grid)
        {
            //
            // View column for cli_nome field
            //
            $column = new TextViewColumn('cli_nome', 'cli_nome', 'Cliente', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for cli_end field
            //
            $column = new TextViewColumn('cli_end', 'cli_end', 'Endereco', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for cli_telefone field
            //
            $column = new TextViewColumn('cli_telefone', 'cli_telefone', 'Telefone', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for cidade_nome field
            //
            $column = new TextViewColumn('cli_cidade', 'cli_cidade_cidade_nome', 'Cidade', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for bairro_nome field
            //
            $column = new TextViewColumn('cli_bairro', 'cli_bairro_bairro_nome', 'Bairro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for cli_nome field
            //
            $column = new TextViewColumn('cli_nome', 'cli_nome', 'Cliente', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for cli_end field
            //
            $column = new TextViewColumn('cli_end', 'cli_end', 'Endereco', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for cli_telefone field
            //
            $column = new TextViewColumn('cli_telefone', 'cli_telefone', 'Telefone', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for cidade_nome field
            //
            $column = new TextViewColumn('cli_cidade', 'cli_cidade_cidade_nome', 'Cidade', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for bairro_nome field
            //
            $column = new TextViewColumn('cli_bairro', 'cli_bairro_bairro_nome', 'Bairro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
    
        }
    
        private function AddCompareHeaderColumns(Grid $grid)
        {
    
        }
    
        public function GetPageDirection()
        {
            return null;
        }
    
        public function isFilterConditionRequired()
        {
            return false;
        }
    
        protected function ApplyCommonColumnEditProperties(CustomEditColumn $column)
        {
            $column->SetDisplaySetToNullCheckBox(false);
            $column->SetDisplaySetToDefaultCheckBox(false);
    		$column->SetVariableContainer($this->GetColumnVariableContainer());
        }
    
        function GetCustomClientScript()
        {
            return ;
        }
        
        function GetOnPageLoadedClientScript()
        {
            return ;
        }
    
        protected function CreateGrid()
        {
            $result = new Grid($this, $this->dataset);
            if ($this->GetSecurityInfo()->HasDeleteGrant())
               $result->SetAllowDeleteSelected(true);
            else
               $result->SetAllowDeleteSelected(false);   
            
            ApplyCommonPageSettings($this, $result);
            
            $result->SetUseImagesForActions(true);
            $result->SetUseFixedHeader(false);
            $result->SetShowLineNumbers(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(true);
            $result->setAllowCompare(true);
            $this->AddCompareHeaderColumns($result);
            $this->AddCompareColumns($result);
            $result->setMultiEditAllowed($this->GetSecurityInfo()->HasEditGrant() && true);
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
            $result->SetHighlightRowAtHover(false);
            $result->SetWidth('');
            $this->AddOperationsColumns($result);
            $this->AddFieldColumns($result);
            $this->AddSingleRecordViewColumns($result);
            $this->AddEditColumns($result);
            $this->AddMultiEditColumns($result);
            $this->AddToggleEditColumns($result);
            $this->AddInsertColumns($result);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            $this->AddMultiUploadColumn($result);
    
    
            $this->SetShowPageList(true);
            $this->SetShowTopPageNavigator(false);
            $this->SetShowBottomPageNavigator(true);
            $this->setAllowedActions(array('view', 'insert', 'copy', 'edit', 'multi-edit', 'delete', 'multi-delete'));
            $this->setPrintListAvailable(true);
            $this->setPrintListRecordAvailable(false);
            $this->setPrintOneRecordAvailable(true);
            $this->setAllowPrintSelectedRecords(true);
            $this->setExportListAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportSelectedRecordsAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
            $this->setExportListRecordAvailable(array());
            $this->setExportOneRecordAvailable(array('pdf', 'excel', 'word', 'xml', 'csv'));
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            
            
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`cidades`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('cidade_id', true, true, true),
                    new StringField('cidade_nome', true)
                )
            );
            $lookupDataset->setOrderByField('cidade_nome', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_clientes_cli_bairro_level1NestedPage_bairro_cidade_search', 'cidade_id', 'cidade_nome', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            
            new clientes_cli_cidadeModalViewPage($this, GetCurrentUserPermissionsForPage('clientes.cli_cidade'));
            new clientes_cli_bairroModalViewPage($this, GetCurrentUserPermissionsForPage('clientes.cli_bairro'));
            new clientes_cli_bairro_level1NestedPage($this, GetCurrentUserPermissionsForPage('clientes.cli_bairro'));
        }
       
        protected function doCustomRenderColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderPrintColumn($fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomRenderExportColumn($exportType, $fieldName, $fieldData, $rowData, &$customText, &$handled)
        { 
    
        }
    
        protected function doCustomDrawRow($rowData, &$cellFontColor, &$cellFontSize, &$cellBgColor, &$cellItalicAttr, &$cellBoldAttr)
        {
    
        }
    
        protected function doExtendedCustomDrawRow($rowData, &$rowCellStyles, &$rowStyles, &$rowClasses, &$cellClasses)
        {
    
        }
    
        protected function doCustomRenderTotal($totalValue, $aggregate, $columnName, &$customText, &$handled)
        {
    
        }
    
        protected function doCustomDefaultValues(&$values, &$handled) 
        {
    
        }
    
        protected function doCustomCompareColumn($columnName, $valueA, $valueB, &$result)
        {
    
        }
    
        protected function doBeforeInsertRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
            $b = array();
            $bairro_id = $rowData['cli_bairro'];
            
            if ($bairro_id <1) {
               $message = " Digite todos os dados!";
               $cancel = true;
            } else {
              
            
            
            $sql = "select bairro_cidade from bairros where bairro_id = {$bairro_id}";
            $this->GetConnection()->ExecQueryToArray($sql,$b);
            
            $rowData['cli_cidade'] = $b[0]['bairro_cidade'];
            }
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
            $b = array();
            $bairro_id = $rowData['cli_bairro'];
            
            if ($bairro_id <1) {
               $message = " Digite todos os dados!";
               $cancel = true;
            } else {
              
            
            
            $sql = "select bairro_cidade from bairros where bairro_id = {$bairro_id}";
            $this->GetConnection()->ExecQueryToArray($sql,$b);
            
            $rowData['cli_cidade'] = $b[0]['bairro_cidade'];
            }
        }
    
        protected function doBeforeDeleteRecord($page, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterInsertRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterUpdateRecord($page, $oldRowData, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doAfterDeleteRecord($page, $rowData, $tableName, &$success, &$message, &$messageDisplayTime)
        {
    
        }
    
        protected function doCustomHTMLHeader($page, &$customHtmlHeaderText)
        { 
    
        }
    
        protected function doGetCustomTemplate($type, $part, $mode, &$result, &$params)
        {
    
        }
    
        protected function doGetCustomExportOptions(Page $page, $exportType, $rowData, &$options)
        {
    
        }
    
        protected function doFileUpload($fieldName, $rowData, &$result, &$accept, $originalFileName, $originalFileExtension, $fileSize, $tempFileName)
        {
    
        }
    
        protected function doPrepareChart(Chart $chart)
        {
    
        }
    
        protected function doPrepareColumnFilter(ColumnFilter $columnFilter)
        {
    
        }
    
        protected function doPrepareFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function doGetSelectionFilters(FixedKeysArray $columns, &$result)
        {
    
        }
    
        protected function doGetCustomFormLayout($mode, FixedKeysArray $columns, FormLayout $layout)
        {
    
        }
    
        protected function doGetCustomColumnGroup(FixedKeysArray $columns, ViewColumnGroup $columnGroup)
        {
    
        }
    
        protected function doPageLoaded()
        {
    
        }
    
        protected function doCalculateFields($rowData, $fieldName, &$value)
        {
    
        }
    
        protected function doGetCustomRecordPermissions(Page $page, &$usingCondition, $rowData, &$allowEdit, &$allowDelete, &$mergeWithDefault, &$handled)
        {
    
        }
    
        protected function doAddEnvironmentVariables(Page $page, &$variables)
        {
    
        }
    
    }

    SetUpUserAuthorization();

    try
    {
        $Page = new clientesPage("clientes", "clientes.php", GetCurrentUserPermissionsForPage("clientes"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("clientes"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
