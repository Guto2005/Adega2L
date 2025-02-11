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
    
    
    
    class ADG2L_CompraProdutoPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('ADG2 L Compra Produto');
            $this->SetMenuLabel('Compra Produto');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_CompraProduto`');
            $this->dataset->addFields(
                array(
                    new IntegerField('idProduto', true, true),
                    new IntegerField('idCompra', true, true),
                    new IntegerField('quantidade')
                )
            );
            $this->dataset->AddLookupField('idProduto', 'ADG2L_Produtos', new IntegerField('idProduto'), new IntegerField('idProduto', false, false, false, false, 'idProduto_idProduto', 'idProduto_idProduto_ADG2L_Produtos'), 'idProduto_idProduto_ADG2L_Produtos');
            $this->dataset->AddLookupField('idCompra', 'ADG2L_CompraEstoque', new IntegerField('idCompra'), new IntegerField('idCompra', false, false, false, false, 'idCompra_idCompra', 'idCompra_idCompra_ADG2L_CompraEstoque'), 'idCompra_idCompra_ADG2L_CompraEstoque');
            $this->dataset->AddLookupField('quantidade', 'ADG2L_CompraEstoque', new IntegerField('idCompra'), new IntegerField('quantidade', false, false, false, false, 'quantidade_quantidade', 'quantidade_quantidade_ADG2L_CompraEstoque'), 'quantidade_quantidade_ADG2L_CompraEstoque');
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
                new FilterColumn($this->dataset, 'idProduto', 'idProduto_idProduto', 'Id Produto'),
                new FilterColumn($this->dataset, 'idCompra', 'idCompra_idCompra', 'Id Compra'),
                new FilterColumn($this->dataset, 'quantidade', 'quantidade_quantidade', 'Quantidade')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['idProduto'])
                ->addColumn($columns['idCompra'])
                ->addColumn($columns['quantidade']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('idProduto')
                ->setOptionsFor('idCompra')
                ->setOptionsFor('quantidade');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('idproduto_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_ADG2L_CompraProduto_idProduto_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idProduto', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_ADG2L_CompraProduto_idProduto_search');
            
            $filterBuilder->addColumn(
                $columns['idProduto'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idcompra_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_ADG2L_CompraProduto_idCompra_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idCompra', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_ADG2L_CompraProduto_idCompra_search');
            
            $filterBuilder->addColumn(
                $columns['idCompra'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('quantidade_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_ADG2L_CompraProduto_quantidade_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('quantidade', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_ADG2L_CompraProduto_quantidade_search');
            
            $filterBuilder->addColumn(
                $columns['quantidade'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
        }
    
        protected function AddOperationsColumns(Grid $grid)
        {
            $actions = $grid->getActions();
            $actions->setCaption($this->GetLocalizerCaptions()->GetMessageString('Actions'));
            $actions->setPosition(ActionList::POSITION_LEFT);
            
            if ($this->GetSecurityInfo()->HasViewGrant()) {
            
                $operation = new AjaxOperation(OPERATION_VIEW,
                    $this->GetLocalizerCaptions()->GetMessageString('View'),
                    $this->GetLocalizerCaptions()->GetMessageString('View'), $this->dataset,
                    $this->GetModalGridViewHandler(), $grid);
                $operation->setUseImage(true);
                $actions->addOperation($operation);
            }
            
            if ($this->GetSecurityInfo()->HasEditGrant())
            {
                $operation = new AjaxOperation(OPERATION_EDIT,
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'),
                    $this->GetLocalizerCaptions()->GetMessageString('Edit'), $this->dataset,
                    $this->GetGridEditHandler(), $grid);
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
            // View column for idProduto field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto_idProduto', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for idCompra field
            //
            $column = new NumberViewColumn('idCompra', 'idCompra_idCompra', 'Id Compra', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for quantidade field
            //
            $column = new NumberViewColumn('quantidade', 'quantidade_quantidade', 'Quantidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for idProduto field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto_idProduto', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for idCompra field
            //
            $column = new NumberViewColumn('idCompra', 'idCompra_idCompra', 'Id Compra', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for quantidade field
            //
            $column = new NumberViewColumn('quantidade', 'quantidade_quantidade', 'Quantidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for idProduto field
            //
            $editor = new DynamicCombobox('idproduto_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Produtos`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idProduto', true, true, true),
                    new IntegerField('idCategoria', true),
                    new IntegerField('idFornecedor', true),
                    new StringField('nomeProduto', true),
                    new IntegerField('precoProduto', true),
                    new IntegerField('quantidadeEstoqueProduto', true),
                    new StringField('descricaoBebidas'),
                    new StringField('tipoUnidade'),
                    new IntegerField('tamanhoUnidade'),
                    new DateField('dataValidade'),
                    new DateTimeField('dataCompraDoProduto'),
                    new StringField('imagemProduto')
                )
            );
            $lookupDataset->setOrderByField('idProduto', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Produto', 'idProduto', 'idProduto_idProduto', 'edit_ADG2L_CompraProduto_idProduto_search', $editor, $this->dataset, $lookupDataset, 'idProduto', 'idProduto', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idCompra field
            //
            $editor = new DynamicCombobox('idcompra_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_CompraEstoque`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCompra', true, true, true),
                    new IntegerField('quantidade', true),
                    new DateTimeField('dataCompra', true),
                    new StringField('descricao'),
                    new IntegerField('idFornecedor', true)
                )
            );
            $lookupDataset->setOrderByField('idCompra', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Compra', 'idCompra', 'idCompra_idCompra', 'edit_ADG2L_CompraProduto_idCompra_search', $editor, $this->dataset, $lookupDataset, 'idCompra', 'idCompra', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for quantidade field
            //
            $editor = new DynamicCombobox('quantidade_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_CompraEstoque`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCompra', true, true, true),
                    new IntegerField('quantidade', true),
                    new DateTimeField('dataCompra', true),
                    new StringField('descricao'),
                    new IntegerField('idFornecedor', true)
                )
            );
            $lookupDataset->setOrderByField('quantidade', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Quantidade', 'quantidade', 'quantidade_quantidade', 'edit_ADG2L_CompraProduto_quantidade_search', $editor, $this->dataset, $lookupDataset, 'idCompra', 'quantidade', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for quantidade field
            //
            $editor = new DynamicCombobox('quantidade_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_CompraEstoque`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCompra', true, true, true),
                    new IntegerField('quantidade', true),
                    new DateTimeField('dataCompra', true),
                    new StringField('descricao'),
                    new IntegerField('idFornecedor', true)
                )
            );
            $lookupDataset->setOrderByField('quantidade', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Quantidade', 'quantidade', 'quantidade_quantidade', 'multi_edit_ADG2L_CompraProduto_quantidade_search', $editor, $this->dataset, $lookupDataset, 'idCompra', 'quantidade', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
        }
    
        protected function AddToggleEditColumns(Grid $grid)
        {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for idProduto field
            //
            $editor = new DynamicCombobox('idproduto_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Produtos`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idProduto', true, true, true),
                    new IntegerField('idCategoria', true),
                    new IntegerField('idFornecedor', true),
                    new StringField('nomeProduto', true),
                    new IntegerField('precoProduto', true),
                    new IntegerField('quantidadeEstoqueProduto', true),
                    new StringField('descricaoBebidas'),
                    new StringField('tipoUnidade'),
                    new IntegerField('tamanhoUnidade'),
                    new DateField('dataValidade'),
                    new DateTimeField('dataCompraDoProduto'),
                    new StringField('imagemProduto')
                )
            );
            $lookupDataset->setOrderByField('idProduto', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Produto', 'idProduto', 'idProduto_idProduto', 'insert_ADG2L_CompraProduto_idProduto_search', $editor, $this->dataset, $lookupDataset, 'idProduto', 'idProduto', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idCompra field
            //
            $editor = new DynamicCombobox('idcompra_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_CompraEstoque`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCompra', true, true, true),
                    new IntegerField('quantidade', true),
                    new DateTimeField('dataCompra', true),
                    new StringField('descricao'),
                    new IntegerField('idFornecedor', true)
                )
            );
            $lookupDataset->setOrderByField('idCompra', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Compra', 'idCompra', 'idCompra_idCompra', 'insert_ADG2L_CompraProduto_idCompra_search', $editor, $this->dataset, $lookupDataset, 'idCompra', 'idCompra', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for quantidade field
            //
            $editor = new DynamicCombobox('quantidade_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_CompraEstoque`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCompra', true, true, true),
                    new IntegerField('quantidade', true),
                    new DateTimeField('dataCompra', true),
                    new StringField('descricao'),
                    new IntegerField('idFornecedor', true)
                )
            );
            $lookupDataset->setOrderByField('quantidade', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Quantidade', 'quantidade', 'quantidade_quantidade', 'insert_ADG2L_CompraProduto_quantidade_search', $editor, $this->dataset, $lookupDataset, 'idCompra', 'quantidade', '');
            $editColumn->SetAllowSetToNull(true);
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
            // View column for idProduto field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto_idProduto', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for idCompra field
            //
            $column = new NumberViewColumn('idCompra', 'idCompra_idCompra', 'Id Compra', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for quantidade field
            //
            $column = new NumberViewColumn('quantidade', 'quantidade_quantidade', 'Quantidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for idProduto field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto_idProduto', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for idCompra field
            //
            $column = new NumberViewColumn('idCompra', 'idCompra_idCompra', 'Id Compra', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for quantidade field
            //
            $column = new NumberViewColumn('quantidade', 'quantidade_quantidade', 'Quantidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for idProduto field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto_idProduto', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for idCompra field
            //
            $column = new NumberViewColumn('idCompra', 'idCompra_idCompra', 'Id Compra', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for quantidade field
            //
            $column = new NumberViewColumn('quantidade', 'quantidade_quantidade', 'Quantidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
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
        public function GetEnableModalSingleRecordView() { return true; }
    
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
            $result->setUseModalMultiEdit(true);
            $result->setTableBordered(true);
            $result->setTableCondensed(true);
            
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
            $this->SetShowTopPageNavigator(true);
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
            $this->setModalViewSize(Modal::SIZE_LG);
            $this->setModalFormSize(Modal::SIZE_LG);
    
            return $result;
        }
     
        protected function setClientSideEvents(Grid $grid) {
    
        }
    
        protected function doRegisterHandlers() {
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Produtos`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idProduto', true, true, true),
                    new IntegerField('idCategoria', true),
                    new IntegerField('idFornecedor', true),
                    new StringField('nomeProduto', true),
                    new IntegerField('precoProduto', true),
                    new IntegerField('quantidadeEstoqueProduto', true),
                    new StringField('descricaoBebidas'),
                    new StringField('tipoUnidade'),
                    new IntegerField('tamanhoUnidade'),
                    new DateField('dataValidade'),
                    new DateTimeField('dataCompraDoProduto'),
                    new StringField('imagemProduto')
                )
            );
            $lookupDataset->setOrderByField('idProduto', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_ADG2L_CompraProduto_idProduto_search', 'idProduto', 'idProduto', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_CompraEstoque`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCompra', true, true, true),
                    new IntegerField('quantidade', true),
                    new DateTimeField('dataCompra', true),
                    new StringField('descricao'),
                    new IntegerField('idFornecedor', true)
                )
            );
            $lookupDataset->setOrderByField('idCompra', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_ADG2L_CompraProduto_idCompra_search', 'idCompra', 'idCompra', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_CompraEstoque`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCompra', true, true, true),
                    new IntegerField('quantidade', true),
                    new DateTimeField('dataCompra', true),
                    new StringField('descricao'),
                    new IntegerField('idFornecedor', true)
                )
            );
            $lookupDataset->setOrderByField('quantidade', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_ADG2L_CompraProduto_quantidade_search', 'idCompra', 'quantidade', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Produtos`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idProduto', true, true, true),
                    new IntegerField('idCategoria', true),
                    new IntegerField('idFornecedor', true),
                    new StringField('nomeProduto', true),
                    new IntegerField('precoProduto', true),
                    new IntegerField('quantidadeEstoqueProduto', true),
                    new StringField('descricaoBebidas'),
                    new StringField('tipoUnidade'),
                    new IntegerField('tamanhoUnidade'),
                    new DateField('dataValidade'),
                    new DateTimeField('dataCompraDoProduto'),
                    new StringField('imagemProduto')
                )
            );
            $lookupDataset->setOrderByField('idProduto', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_ADG2L_CompraProduto_idProduto_search', 'idProduto', 'idProduto', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_CompraEstoque`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCompra', true, true, true),
                    new IntegerField('quantidade', true),
                    new DateTimeField('dataCompra', true),
                    new StringField('descricao'),
                    new IntegerField('idFornecedor', true)
                )
            );
            $lookupDataset->setOrderByField('idCompra', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_ADG2L_CompraProduto_idCompra_search', 'idCompra', 'idCompra', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_CompraEstoque`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCompra', true, true, true),
                    new IntegerField('quantidade', true),
                    new DateTimeField('dataCompra', true),
                    new StringField('descricao'),
                    new IntegerField('idFornecedor', true)
                )
            );
            $lookupDataset->setOrderByField('quantidade', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_ADG2L_CompraProduto_quantidade_search', 'idCompra', 'quantidade', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Produtos`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idProduto', true, true, true),
                    new IntegerField('idCategoria', true),
                    new IntegerField('idFornecedor', true),
                    new StringField('nomeProduto', true),
                    new IntegerField('precoProduto', true),
                    new IntegerField('quantidadeEstoqueProduto', true),
                    new StringField('descricaoBebidas'),
                    new StringField('tipoUnidade'),
                    new IntegerField('tamanhoUnidade'),
                    new DateField('dataValidade'),
                    new DateTimeField('dataCompraDoProduto'),
                    new StringField('imagemProduto')
                )
            );
            $lookupDataset->setOrderByField('idProduto', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_ADG2L_CompraProduto_idProduto_search', 'idProduto', 'idProduto', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_CompraEstoque`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCompra', true, true, true),
                    new IntegerField('quantidade', true),
                    new DateTimeField('dataCompra', true),
                    new StringField('descricao'),
                    new IntegerField('idFornecedor', true)
                )
            );
            $lookupDataset->setOrderByField('idCompra', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_ADG2L_CompraProduto_idCompra_search', 'idCompra', 'idCompra', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_CompraEstoque`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCompra', true, true, true),
                    new IntegerField('quantidade', true),
                    new DateTimeField('dataCompra', true),
                    new StringField('descricao'),
                    new IntegerField('idFornecedor', true)
                )
            );
            $lookupDataset->setOrderByField('quantidade', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_ADG2L_CompraProduto_quantidade_search', 'idCompra', 'quantidade', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_CompraEstoque`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCompra', true, true, true),
                    new IntegerField('quantidade', true),
                    new DateTimeField('dataCompra', true),
                    new StringField('descricao'),
                    new IntegerField('idFornecedor', true)
                )
            );
            $lookupDataset->setOrderByField('quantidade', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_ADG2L_CompraProduto_quantidade_search', 'idCompra', 'quantidade', null, 20);
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
        $Page = new ADG2L_CompraProdutoPage("ADG2L_CompraProduto", "ADG2L_CompraProduto.php", GetCurrentUserPermissionsForPage("ADG2L_CompraProduto"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("ADG2L_CompraProduto"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
