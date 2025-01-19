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

    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class itensPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Itens');
            $this->SetMenuLabel('Itens');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`itens`');
            $this->dataset->addFields(
                array(
                    new IntegerField('item_id', true, true, true),
                    new IntegerField('item_produto', true),
                    new IntegerField('item_valor', true),
                    new IntegerField('item_qtd', true),
                    new StringField('item_serv_cod', true)
                )
            );
            $this->dataset->AddLookupField('item_produto', 'produtos', new StringField('pro_nome'), new StringField('pro_nome', false, false, false, false, 'item_produto_pro_nome', 'item_produto_pro_nome_produtos'), 'item_produto_pro_nome_produtos');
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
                new FilterColumn($this->dataset, 'item_id', 'item_id', 'Item Id'),
                new FilterColumn($this->dataset, 'item_produto', 'item_produto_pro_nome', 'Item Produto'),
                new FilterColumn($this->dataset, 'item_valor', 'item_valor', 'Item Valor'),
                new FilterColumn($this->dataset, 'item_qtd', 'item_qtd', 'Item Qtd'),
                new FilterColumn($this->dataset, 'item_serv_cod', 'item_serv_cod', 'Item Serv Cod')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['item_id'])
                ->addColumn($columns['item_produto'])
                ->addColumn($columns['item_valor'])
                ->addColumn($columns['item_qtd'])
                ->addColumn($columns['item_serv_cod']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('item_produto');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
    
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
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
        }
    
        protected function AddFieldColumns(Grid $grid, $withDetails = true)
        {
            //
            // View column for item_id field
            //
            $column = new NumberViewColumn('item_id', 'item_id', 'Item Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for pro_nome field
            //
            $column = new TextViewColumn('item_produto', 'item_produto_pro_nome', 'Item Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for item_valor field
            //
            $column = new NumberViewColumn('item_valor', 'item_valor', 'Item Valor', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for item_qtd field
            //
            $column = new NumberViewColumn('item_qtd', 'item_qtd', 'Item Qtd', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for item_serv_cod field
            //
            $column = new TextViewColumn('item_serv_cod', 'item_serv_cod', 'Item Serv Cod', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for item_id field
            //
            $column = new NumberViewColumn('item_id', 'item_id', 'Item Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for pro_nome field
            //
            $column = new TextViewColumn('item_produto', 'item_produto_pro_nome', 'Item Produto', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for item_valor field
            //
            $column = new NumberViewColumn('item_valor', 'item_valor', 'Item Valor', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for item_qtd field
            //
            $column = new NumberViewColumn('item_qtd', 'item_qtd', 'Item Qtd', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for item_serv_cod field
            //
            $column = new TextViewColumn('item_serv_cod', 'item_serv_cod', 'Item Serv Cod', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for item_id field
            //
            $editor = new TextEdit('item_id_edit');
            $editColumn = new CustomEditColumn('Item Id', 'item_id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for item_produto field
            //
            $editor = new DynamicCombobox('item_produto_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`produtos`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('pro_id', true, true, true),
                    new StringField('pro_nome', true),
                    new IntegerField('pro_valor', true),
                    new StringField('pro_cod'),
                    new IntegerField('pro_estoque', true),
                    new StringField('pro_img')
                )
            );
            $lookupDataset->setOrderByField('pro_nome', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Item Produto', 'item_produto', 'item_produto_pro_nome', 'edit_itens_item_produto_search', $editor, $this->dataset, $lookupDataset, 'pro_nome', 'pro_nome', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for item_valor field
            //
            $editor = new TextEdit('item_valor_edit');
            $editColumn = new CustomEditColumn('Item Valor', 'item_valor', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for item_qtd field
            //
            $editor = new TextEdit('item_qtd_edit');
            $editColumn = new CustomEditColumn('Item Qtd', 'item_qtd', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for item_serv_cod field
            //
            $editor = new TextEdit('item_serv_cod_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Item Serv Cod', 'item_serv_cod', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for item_produto field
            //
            $editor = new DynamicCombobox('item_produto_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`produtos`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('pro_id', true, true, true),
                    new StringField('pro_nome', true),
                    new IntegerField('pro_valor', true),
                    new StringField('pro_cod'),
                    new IntegerField('pro_estoque', true),
                    new StringField('pro_img')
                )
            );
            $lookupDataset->setOrderByField('pro_nome', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Item Produto', 'item_produto', 'item_produto_pro_nome', 'multi_edit_itens_item_produto_search', $editor, $this->dataset, $lookupDataset, 'pro_nome', 'pro_nome', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for item_valor field
            //
            $editor = new TextEdit('item_valor_edit');
            $editColumn = new CustomEditColumn('Item Valor', 'item_valor', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for item_qtd field
            //
            $editor = new TextEdit('item_qtd_edit');
            $editColumn = new CustomEditColumn('Item Qtd', 'item_qtd', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for item_serv_cod field
            //
            $editor = new TextEdit('item_serv_cod_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Item Serv Cod', 'item_serv_cod', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddToggleEditColumns(Grid $grid)
        {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for item_id field
            //
            $editor = new TextEdit('item_id_edit');
            $editColumn = new CustomEditColumn('Item Id', 'item_id', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for item_produto field
            //
            $editor = new DynamicCombobox('item_produto_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`produtos`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('pro_id', true, true, true),
                    new StringField('pro_nome', true),
                    new IntegerField('pro_valor', true),
                    new StringField('pro_cod'),
                    new IntegerField('pro_estoque', true),
                    new StringField('pro_img')
                )
            );
            $lookupDataset->setOrderByField('pro_nome', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Item Produto', 'item_produto', 'item_produto_pro_nome', 'insert_itens_item_produto_search', $editor, $this->dataset, $lookupDataset, 'pro_nome', 'pro_nome', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for item_valor field
            //
            $editor = new TextEdit('item_valor_edit');
            $editColumn = new CustomEditColumn('Item Valor', 'item_valor', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for item_qtd field
            //
            $editor = new TextEdit('item_qtd_edit');
            $editColumn = new CustomEditColumn('Item Qtd', 'item_qtd', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for item_serv_cod field
            //
            $editor = new TextEdit('item_serv_cod_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Item Serv Cod', 'item_serv_cod', $editor, $this->dataset);
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
            // View column for item_id field
            //
            $column = new NumberViewColumn('item_id', 'item_id', 'Item Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for pro_nome field
            //
            $column = new TextViewColumn('item_produto', 'item_produto_pro_nome', 'Item Produto', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for item_valor field
            //
            $column = new NumberViewColumn('item_valor', 'item_valor', 'Item Valor', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddPrintColumn($column);
            
            //
            // View column for item_qtd field
            //
            $column = new NumberViewColumn('item_qtd', 'item_qtd', 'Item Qtd', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for item_serv_cod field
            //
            $column = new TextViewColumn('item_serv_cod', 'item_serv_cod', 'Item Serv Cod', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for item_id field
            //
            $column = new NumberViewColumn('item_id', 'item_id', 'Item Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for pro_nome field
            //
            $column = new TextViewColumn('item_produto', 'item_produto_pro_nome', 'Item Produto', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for item_valor field
            //
            $column = new NumberViewColumn('item_valor', 'item_valor', 'Item Valor', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddExportColumn($column);
            
            //
            // View column for item_qtd field
            //
            $column = new NumberViewColumn('item_qtd', 'item_qtd', 'Item Qtd', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for item_serv_cod field
            //
            $column = new TextViewColumn('item_serv_cod', 'item_serv_cod', 'Item Serv Cod', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for item_id field
            //
            $column = new NumberViewColumn('item_id', 'item_id', 'Item Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for pro_nome field
            //
            $column = new TextViewColumn('item_produto', 'item_produto_pro_nome', 'Item Produto', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for item_valor field
            //
            $column = new NumberViewColumn('item_valor', 'item_valor', 'Item Valor', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddCompareColumn($column);
            
            //
            // View column for item_qtd field
            //
            $column = new NumberViewColumn('item_qtd', 'item_qtd', 'Item Qtd', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for item_serv_cod field
            //
            $column = new TextViewColumn('item_serv_cod', 'item_serv_cod', 'Item Serv Cod', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
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
            $this->setAllowedActions(array('insert', 'edit', 'multi-edit', 'delete', 'multi-delete'));
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
                '`produtos`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('pro_id', true, true, true),
                    new StringField('pro_nome', true),
                    new IntegerField('pro_valor', true),
                    new StringField('pro_cod'),
                    new IntegerField('pro_estoque', true),
                    new StringField('pro_img')
                )
            );
            $lookupDataset->setOrderByField('pro_nome', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_itens_item_produto_search', 'pro_nome', 'pro_nome', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`produtos`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('pro_id', true, true, true),
                    new StringField('pro_nome', true),
                    new IntegerField('pro_valor', true),
                    new StringField('pro_cod'),
                    new IntegerField('pro_estoque', true),
                    new StringField('pro_img')
                )
            );
            $lookupDataset->setOrderByField('pro_nome', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_itens_item_produto_search', 'pro_nome', 'pro_nome', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`produtos`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('pro_id', true, true, true),
                    new StringField('pro_nome', true),
                    new IntegerField('pro_valor', true),
                    new StringField('pro_cod'),
                    new IntegerField('pro_estoque', true),
                    new StringField('pro_img')
                )
            );
            $lookupDataset->setOrderByField('pro_nome', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_itens_item_produto_search', 'pro_nome', 'pro_nome', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
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
    
        }
    
        protected function doBeforeUpdateRecord($page, $oldRowData, &$rowData, $tableName, &$cancel, &$message, &$messageDisplayTime)
        {
    
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
        $Page = new itensPage("itens", "itens.php", GetCurrentUserPermissionsForPage("itens"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("itens"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
