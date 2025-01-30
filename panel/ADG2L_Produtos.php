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
    
    
    
    class ADG2L_Produtos_ADG2L_MovimentacaoEstoquePage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('ADG2 L Movimentacao Estoque');
            $this->SetMenuLabel('ADG2 L Movimentacao Estoque');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_MovimentacaoEstoque`');
            $this->dataset->addFields(
                array(
                    new IntegerField('idMovimentacao', true, true, true),
                    new IntegerField('idProduto', true),
                    new StringField('tipoMovimentacao', true),
                    new IntegerField('quantidade', true),
                    new DateTimeField('dataMovimentacao', true),
                    new StringField('descricao')
                )
            );
            $this->dataset->AddLookupField('idProduto', 'ADG2L_Produtos', new IntegerField('idProduto'), new IntegerField('idCategoria', false, false, false, false, 'idProduto_idCategoria', 'idProduto_idCategoria_ADG2L_Produtos'), 'idProduto_idCategoria_ADG2L_Produtos');
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
                new FilterColumn($this->dataset, 'idMovimentacao', 'idMovimentacao', 'Id Movimentacao'),
                new FilterColumn($this->dataset, 'idProduto', 'idProduto_idCategoria', 'Id Produto'),
                new FilterColumn($this->dataset, 'tipoMovimentacao', 'tipoMovimentacao', 'Tipo Movimentacao'),
                new FilterColumn($this->dataset, 'quantidade', 'quantidade', 'Quantidade'),
                new FilterColumn($this->dataset, 'dataMovimentacao', 'dataMovimentacao', 'Data Movimentacao'),
                new FilterColumn($this->dataset, 'descricao', 'descricao', 'Descricao')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['idMovimentacao'])
                ->addColumn($columns['idProduto'])
                ->addColumn($columns['tipoMovimentacao'])
                ->addColumn($columns['quantidade'])
                ->addColumn($columns['dataMovimentacao'])
                ->addColumn($columns['descricao']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('idProduto')
                ->setOptionsFor('dataMovimentacao');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('idmovimentacao_edit');
            
            $filterBuilder->addColumn(
                $columns['idMovimentacao'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idproduto_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_ADG2L_Produtos_ADG2L_MovimentacaoEstoque_idProduto_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idProduto', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_ADG2L_Produtos_ADG2L_MovimentacaoEstoque_idProduto_search');
            
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
            
            $main_editor = new TextEdit('tipomovimentacao_edit');
            $main_editor->SetMaxLength(10);
            
            $filterBuilder->addColumn(
                $columns['tipoMovimentacao'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('quantidade_edit');
            
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('datamovimentacao_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['dataMovimentacao'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('descricao');
            
            $filterBuilder->addColumn(
                $columns['descricao'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
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
            // View column for idMovimentacao field
            //
            $column = new NumberViewColumn('idMovimentacao', 'idMovimentacao', 'Id Movimentacao', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for idCategoria field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto_idCategoria', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for tipoMovimentacao field
            //
            $column = new TextViewColumn('tipoMovimentacao', 'tipoMovimentacao', 'Tipo Movimentacao', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for quantidade field
            //
            $column = new NumberViewColumn('quantidade', 'quantidade', 'Quantidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for dataMovimentacao field
            //
            $column = new DateTimeViewColumn('dataMovimentacao', 'dataMovimentacao', 'Data Movimentacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for descricao field
            //
            $column = new TextViewColumn('descricao', 'descricao', 'Descricao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for idMovimentacao field
            //
            $column = new NumberViewColumn('idMovimentacao', 'idMovimentacao', 'Id Movimentacao', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for idCategoria field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto_idCategoria', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tipoMovimentacao field
            //
            $column = new TextViewColumn('tipoMovimentacao', 'tipoMovimentacao', 'Tipo Movimentacao', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for quantidade field
            //
            $column = new NumberViewColumn('quantidade', 'quantidade', 'Quantidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for dataMovimentacao field
            //
            $column = new DateTimeViewColumn('dataMovimentacao', 'dataMovimentacao', 'Data Movimentacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for descricao field
            //
            $column = new TextViewColumn('descricao', 'descricao', 'Descricao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for idMovimentacao field
            //
            $editor = new TextEdit('idmovimentacao_edit');
            $editColumn = new CustomEditColumn('Id Movimentacao', 'idMovimentacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
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
            $lookupDataset->setOrderByField('idCategoria', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Produto', 'idProduto', 'idProduto_idCategoria', 'edit_ADG2L_Produtos_ADG2L_MovimentacaoEstoque_idProduto_search', $editor, $this->dataset, $lookupDataset, 'idProduto', 'idCategoria', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipoMovimentacao field
            //
            $editor = new TextEdit('tipomovimentacao_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Tipo Movimentacao', 'tipoMovimentacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for quantidade field
            //
            $editor = new TextEdit('quantidade_edit');
            $editColumn = new CustomEditColumn('Quantidade', 'quantidade', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for dataMovimentacao field
            //
            $editor = new DateTimeEdit('datamovimentacao_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Data Movimentacao', 'dataMovimentacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for descricao field
            //
            $editor = new TextAreaEdit('descricao_edit', 50, 8);
            $editColumn = new CustomEditColumn('Descricao', 'descricao', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
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
            $lookupDataset->setOrderByField('idCategoria', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Produto', 'idProduto', 'idProduto_idCategoria', 'multi_edit_ADG2L_Produtos_ADG2L_MovimentacaoEstoque_idProduto_search', $editor, $this->dataset, $lookupDataset, 'idProduto', 'idCategoria', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tipoMovimentacao field
            //
            $editor = new TextEdit('tipomovimentacao_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Tipo Movimentacao', 'tipoMovimentacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for quantidade field
            //
            $editor = new TextEdit('quantidade_edit');
            $editColumn = new CustomEditColumn('Quantidade', 'quantidade', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for dataMovimentacao field
            //
            $editor = new DateTimeEdit('datamovimentacao_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Data Movimentacao', 'dataMovimentacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for descricao field
            //
            $editor = new TextAreaEdit('descricao_edit', 50, 8);
            $editColumn = new CustomEditColumn('Descricao', 'descricao', $editor, $this->dataset);
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
            // Edit column for idMovimentacao field
            //
            $editor = new TextEdit('idmovimentacao_edit');
            $editColumn = new CustomEditColumn('Id Movimentacao', 'idMovimentacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
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
            $lookupDataset->setOrderByField('idCategoria', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Produto', 'idProduto', 'idProduto_idCategoria', 'insert_ADG2L_Produtos_ADG2L_MovimentacaoEstoque_idProduto_search', $editor, $this->dataset, $lookupDataset, 'idProduto', 'idCategoria', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipoMovimentacao field
            //
            $editor = new TextEdit('tipomovimentacao_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Tipo Movimentacao', 'tipoMovimentacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for quantidade field
            //
            $editor = new TextEdit('quantidade_edit');
            $editColumn = new CustomEditColumn('Quantidade', 'quantidade', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for dataMovimentacao field
            //
            $editor = new DateTimeEdit('datamovimentacao_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Data Movimentacao', 'dataMovimentacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for descricao field
            //
            $editor = new TextAreaEdit('descricao_edit', 50, 8);
            $editColumn = new CustomEditColumn('Descricao', 'descricao', $editor, $this->dataset);
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
            // View column for idMovimentacao field
            //
            $column = new NumberViewColumn('idMovimentacao', 'idMovimentacao', 'Id Movimentacao', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for idCategoria field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto_idCategoria', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for tipoMovimentacao field
            //
            $column = new TextViewColumn('tipoMovimentacao', 'tipoMovimentacao', 'Tipo Movimentacao', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for quantidade field
            //
            $column = new NumberViewColumn('quantidade', 'quantidade', 'Quantidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for dataMovimentacao field
            //
            $column = new DateTimeViewColumn('dataMovimentacao', 'dataMovimentacao', 'Data Movimentacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for descricao field
            //
            $column = new TextViewColumn('descricao', 'descricao', 'Descricao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for idMovimentacao field
            //
            $column = new NumberViewColumn('idMovimentacao', 'idMovimentacao', 'Id Movimentacao', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for idCategoria field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto_idCategoria', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for tipoMovimentacao field
            //
            $column = new TextViewColumn('tipoMovimentacao', 'tipoMovimentacao', 'Tipo Movimentacao', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for quantidade field
            //
            $column = new NumberViewColumn('quantidade', 'quantidade', 'Quantidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for dataMovimentacao field
            //
            $column = new DateTimeViewColumn('dataMovimentacao', 'dataMovimentacao', 'Data Movimentacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for descricao field
            //
            $column = new TextViewColumn('descricao', 'descricao', 'Descricao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for idMovimentacao field
            //
            $column = new NumberViewColumn('idMovimentacao', 'idMovimentacao', 'Id Movimentacao', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for idCategoria field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto_idCategoria', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for tipoMovimentacao field
            //
            $column = new TextViewColumn('tipoMovimentacao', 'tipoMovimentacao', 'Tipo Movimentacao', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for quantidade field
            //
            $column = new NumberViewColumn('quantidade', 'quantidade', 'Quantidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for dataMovimentacao field
            //
            $column = new DateTimeViewColumn('dataMovimentacao', 'dataMovimentacao', 'Data Movimentacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for descricao field
            //
            $column = new TextViewColumn('descricao', 'descricao', 'Descricao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
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
            $lookupDataset->setOrderByField('idCategoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_ADG2L_Produtos_ADG2L_MovimentacaoEstoque_idProduto_search', 'idProduto', 'idCategoria', null, 20);
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
            $lookupDataset->setOrderByField('idCategoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_ADG2L_Produtos_ADG2L_MovimentacaoEstoque_idProduto_search', 'idProduto', 'idCategoria', null, 20);
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
            $lookupDataset->setOrderByField('idCategoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_ADG2L_Produtos_ADG2L_MovimentacaoEstoque_idProduto_search', 'idProduto', 'idCategoria', null, 20);
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
            $lookupDataset->setOrderByField('idCategoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_ADG2L_Produtos_ADG2L_MovimentacaoEstoque_idProduto_search', 'idProduto', 'idCategoria', null, 20);
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
    
    
    
    
    // OnBeforePageExecute event handler
    
    
    
    class ADG2L_Produtos_ADG2L_VendaProdutosPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('ADG2 L Venda Produtos');
            $this->SetMenuLabel('ADG2 L Venda Produtos');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_VendaProdutos`');
            $this->dataset->addFields(
                array(
                    new IntegerField('idProduto', true, true),
                    new IntegerField('idVenda', true, true),
                    new IntegerField('qtdItensVendidos', true)
                )
            );
            $this->dataset->AddLookupField('idProduto', 'ADG2L_Produtos', new IntegerField('idProduto'), new IntegerField('idCategoria', false, false, false, false, 'idProduto_idCategoria', 'idProduto_idCategoria_ADG2L_Produtos'), 'idProduto_idCategoria_ADG2L_Produtos');
            $this->dataset->AddLookupField('idVenda', 'ADG2L_Vendas', new IntegerField('idVenda'), new IntegerField('idUsuario', false, false, false, false, 'idVenda_idUsuario', 'idVenda_idUsuario_ADG2L_Vendas'), 'idVenda_idUsuario_ADG2L_Vendas');
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
                new FilterColumn($this->dataset, 'idProduto', 'idProduto_idCategoria', 'Id Produto'),
                new FilterColumn($this->dataset, 'idVenda', 'idVenda_idUsuario', 'Id Venda'),
                new FilterColumn($this->dataset, 'qtdItensVendidos', 'qtdItensVendidos', 'Qtd Itens Vendidos')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['idProduto'])
                ->addColumn($columns['idVenda'])
                ->addColumn($columns['qtdItensVendidos']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('idProduto')
                ->setOptionsFor('idVenda');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('idproduto_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_ADG2L_Produtos_ADG2L_VendaProdutos_idProduto_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idProduto', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_ADG2L_Produtos_ADG2L_VendaProdutos_idProduto_search');
            
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
            
            $main_editor = new DynamicCombobox('idvenda_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_ADG2L_Produtos_ADG2L_VendaProdutos_idVenda_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idVenda', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_ADG2L_Produtos_ADG2L_VendaProdutos_idVenda_search');
            
            $filterBuilder->addColumn(
                $columns['idVenda'],
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
            
            $main_editor = new TextEdit('qtditensvendidos_edit');
            
            $filterBuilder->addColumn(
                $columns['qtdItensVendidos'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
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
            // View column for idCategoria field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto_idCategoria', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for idUsuario field
            //
            $column = new NumberViewColumn('idVenda', 'idVenda_idUsuario', 'Id Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for qtdItensVendidos field
            //
            $column = new NumberViewColumn('qtdItensVendidos', 'qtdItensVendidos', 'Qtd Itens Vendidos', $this->dataset);
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
            // View column for idCategoria field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto_idCategoria', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for idUsuario field
            //
            $column = new NumberViewColumn('idVenda', 'idVenda_idUsuario', 'Id Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for qtdItensVendidos field
            //
            $column = new NumberViewColumn('qtdItensVendidos', 'qtdItensVendidos', 'Qtd Itens Vendidos', $this->dataset);
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
            $lookupDataset->setOrderByField('idCategoria', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Produto', 'idProduto', 'idProduto_idCategoria', 'edit_ADG2L_Produtos_ADG2L_VendaProdutos_idProduto_search', $editor, $this->dataset, $lookupDataset, 'idProduto', 'idCategoria', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idVenda field
            //
            $editor = new DynamicCombobox('idvenda_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Vendas`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idVenda', true, true, true),
                    new IntegerField('idUsuario', true),
                    new DateTimeField('dataVenda', true),
                    new IntegerField('valorTotalVenda', true),
                    new StringField('formaDePagamento', true)
                )
            );
            $lookupDataset->setOrderByField('idUsuario', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Venda', 'idVenda', 'idVenda_idUsuario', 'edit_ADG2L_Produtos_ADG2L_VendaProdutos_idVenda_search', $editor, $this->dataset, $lookupDataset, 'idVenda', 'idUsuario', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for qtdItensVendidos field
            //
            $editor = new TextEdit('qtditensvendidos_edit');
            $editColumn = new CustomEditColumn('Qtd Itens Vendidos', 'qtdItensVendidos', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for qtdItensVendidos field
            //
            $editor = new TextEdit('qtditensvendidos_edit');
            $editColumn = new CustomEditColumn('Qtd Itens Vendidos', 'qtdItensVendidos', $editor, $this->dataset);
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
            $lookupDataset->setOrderByField('idCategoria', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Produto', 'idProduto', 'idProduto_idCategoria', 'insert_ADG2L_Produtos_ADG2L_VendaProdutos_idProduto_search', $editor, $this->dataset, $lookupDataset, 'idProduto', 'idCategoria', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idVenda field
            //
            $editor = new DynamicCombobox('idvenda_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Vendas`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idVenda', true, true, true),
                    new IntegerField('idUsuario', true),
                    new DateTimeField('dataVenda', true),
                    new IntegerField('valorTotalVenda', true),
                    new StringField('formaDePagamento', true)
                )
            );
            $lookupDataset->setOrderByField('idUsuario', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Venda', 'idVenda', 'idVenda_idUsuario', 'insert_ADG2L_Produtos_ADG2L_VendaProdutos_idVenda_search', $editor, $this->dataset, $lookupDataset, 'idVenda', 'idUsuario', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for qtdItensVendidos field
            //
            $editor = new TextEdit('qtditensvendidos_edit');
            $editColumn = new CustomEditColumn('Qtd Itens Vendidos', 'qtdItensVendidos', $editor, $this->dataset);
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
            // View column for idCategoria field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto_idCategoria', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for idUsuario field
            //
            $column = new NumberViewColumn('idVenda', 'idVenda_idUsuario', 'Id Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for qtdItensVendidos field
            //
            $column = new NumberViewColumn('qtdItensVendidos', 'qtdItensVendidos', 'Qtd Itens Vendidos', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for idCategoria field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto_idCategoria', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for idUsuario field
            //
            $column = new NumberViewColumn('idVenda', 'idVenda_idUsuario', 'Id Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for qtdItensVendidos field
            //
            $column = new NumberViewColumn('qtdItensVendidos', 'qtdItensVendidos', 'Qtd Itens Vendidos', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for idCategoria field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto_idCategoria', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for idUsuario field
            //
            $column = new NumberViewColumn('idVenda', 'idVenda_idUsuario', 'Id Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for qtdItensVendidos field
            //
            $column = new NumberViewColumn('qtdItensVendidos', 'qtdItensVendidos', 'Qtd Itens Vendidos', $this->dataset);
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
            $lookupDataset->setOrderByField('idCategoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_ADG2L_Produtos_ADG2L_VendaProdutos_idProduto_search', 'idProduto', 'idCategoria', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Vendas`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idVenda', true, true, true),
                    new IntegerField('idUsuario', true),
                    new DateTimeField('dataVenda', true),
                    new IntegerField('valorTotalVenda', true),
                    new StringField('formaDePagamento', true)
                )
            );
            $lookupDataset->setOrderByField('idUsuario', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_ADG2L_Produtos_ADG2L_VendaProdutos_idVenda_search', 'idVenda', 'idUsuario', null, 20);
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
            $lookupDataset->setOrderByField('idCategoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_ADG2L_Produtos_ADG2L_VendaProdutos_idProduto_search', 'idProduto', 'idCategoria', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Vendas`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idVenda', true, true, true),
                    new IntegerField('idUsuario', true),
                    new DateTimeField('dataVenda', true),
                    new IntegerField('valorTotalVenda', true),
                    new StringField('formaDePagamento', true)
                )
            );
            $lookupDataset->setOrderByField('idUsuario', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_ADG2L_Produtos_ADG2L_VendaProdutos_idVenda_search', 'idVenda', 'idUsuario', null, 20);
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
            $lookupDataset->setOrderByField('idCategoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_ADG2L_Produtos_ADG2L_VendaProdutos_idProduto_search', 'idProduto', 'idCategoria', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Vendas`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idVenda', true, true, true),
                    new IntegerField('idUsuario', true),
                    new DateTimeField('dataVenda', true),
                    new IntegerField('valorTotalVenda', true),
                    new StringField('formaDePagamento', true)
                )
            );
            $lookupDataset->setOrderByField('idUsuario', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_ADG2L_Produtos_ADG2L_VendaProdutos_idVenda_search', 'idVenda', 'idUsuario', null, 20);
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
    
    // OnBeforePageExecute event handler
    
    
    
    class ADG2L_ProdutosPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('ADG2 L Produtos');
            $this->SetMenuLabel('ADG2 L Produtos');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Produtos`');
            $this->dataset->addFields(
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
            $this->dataset->AddLookupField('idCategoria', 'ADG2L_Categorias', new IntegerField('idCategoria'), new StringField('nomeCategoria', false, false, false, false, 'idCategoria_nomeCategoria', 'idCategoria_nomeCategoria_ADG2L_Categorias'), 'idCategoria_nomeCategoria_ADG2L_Categorias');
            $this->dataset->AddLookupField('idFornecedor', 'ADG2L_Fornecedor', new IntegerField('idFornecedor'), new StringField('nomeFornecedor', false, false, false, false, 'idFornecedor_nomeFornecedor', 'idFornecedor_nomeFornecedor_ADG2L_Fornecedor'), 'idFornecedor_nomeFornecedor_ADG2L_Fornecedor');
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
                new FilterColumn($this->dataset, 'idProduto', 'idProduto', 'Id Produto'),
                new FilterColumn($this->dataset, 'idCategoria', 'idCategoria_nomeCategoria', 'Id Categoria'),
                new FilterColumn($this->dataset, 'idFornecedor', 'idFornecedor_nomeFornecedor', 'Id Fornecedor'),
                new FilterColumn($this->dataset, 'nomeProduto', 'nomeProduto', 'Nome Produto'),
                new FilterColumn($this->dataset, 'precoProduto', 'precoProduto', 'Preco Produto'),
                new FilterColumn($this->dataset, 'quantidadeEstoqueProduto', 'quantidadeEstoqueProduto', 'Quantidade Estoque Produto'),
                new FilterColumn($this->dataset, 'descricaoBebidas', 'descricaoBebidas', 'Descricao Bebidas'),
                new FilterColumn($this->dataset, 'tipoUnidade', 'tipoUnidade', 'Tipo Unidade'),
                new FilterColumn($this->dataset, 'tamanhoUnidade', 'tamanhoUnidade', 'Tamanho Unidade'),
                new FilterColumn($this->dataset, 'dataValidade', 'dataValidade', 'Data Validade'),
                new FilterColumn($this->dataset, 'dataCompraDoProduto', 'dataCompraDoProduto', 'Data Compra Do Produto'),
                new FilterColumn($this->dataset, 'imagemProduto', 'imagemProduto', 'Imagem Produto')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['idProduto'])
                ->addColumn($columns['idCategoria'])
                ->addColumn($columns['idFornecedor'])
                ->addColumn($columns['nomeProduto'])
                ->addColumn($columns['precoProduto'])
                ->addColumn($columns['quantidadeEstoqueProduto'])
                ->addColumn($columns['descricaoBebidas'])
                ->addColumn($columns['tipoUnidade'])
                ->addColumn($columns['tamanhoUnidade'])
                ->addColumn($columns['dataValidade'])
                ->addColumn($columns['dataCompraDoProduto'])
                ->addColumn($columns['imagemProduto']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('idCategoria')
                ->setOptionsFor('idFornecedor')
                ->setOptionsFor('dataValidade')
                ->setOptionsFor('dataCompraDoProduto');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('idproduto_edit');
            
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idcategoria_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_ADG2L_Produtos_idCategoria_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idCategoria', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_ADG2L_Produtos_idCategoria_search');
            
            $text_editor = new TextEdit('idCategoria');
            
            $filterBuilder->addColumn(
                $columns['idCategoria'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idfornecedor_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_ADG2L_Produtos_idFornecedor_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idFornecedor', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_ADG2L_Produtos_idFornecedor_search');
            
            $text_editor = new TextEdit('idFornecedor');
            
            $filterBuilder->addColumn(
                $columns['idFornecedor'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $text_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $text_editor,
                    FilterConditionOperator::BEGINS_WITH => $text_editor,
                    FilterConditionOperator::ENDS_WITH => $text_editor,
                    FilterConditionOperator::IS_LIKE => $text_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $text_editor,
                    FilterConditionOperator::IN => $multi_value_select_editor,
                    FilterConditionOperator::NOT_IN => $multi_value_select_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('nomeproduto_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['nomeProduto'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('precoproduto_edit');
            
            $filterBuilder->addColumn(
                $columns['precoProduto'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('quantidadeestoqueproduto_edit');
            
            $filterBuilder->addColumn(
                $columns['quantidadeEstoqueProduto'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('descricaoBebidas');
            
            $filterBuilder->addColumn(
                $columns['descricaoBebidas'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('tipounidade_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['tipoUnidade'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('tamanhounidade_edit');
            
            $filterBuilder->addColumn(
                $columns['tamanhoUnidade'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('datavalidade_edit', false, 'd-m-Y');
            
            $filterBuilder->addColumn(
                $columns['dataValidade'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DateTimeEdit('datacompradoproduto_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['dataCompraDoProduto'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::DATE_EQUALS => $main_editor,
                    FilterConditionOperator::DATE_DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::TODAY => null,
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new TextEdit('imagemProduto');
            
            $filterBuilder->addColumn(
                $columns['imagemProduto'],
                array(
                    FilterConditionOperator::EQUALS => $main_editor,
                    FilterConditionOperator::DOES_NOT_EQUAL => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN => $main_editor,
                    FilterConditionOperator::IS_GREATER_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN => $main_editor,
                    FilterConditionOperator::IS_LESS_THAN_OR_EQUAL_TO => $main_editor,
                    FilterConditionOperator::IS_BETWEEN => $main_editor,
                    FilterConditionOperator::IS_NOT_BETWEEN => $main_editor,
                    FilterConditionOperator::CONTAINS => $main_editor,
                    FilterConditionOperator::DOES_NOT_CONTAIN => $main_editor,
                    FilterConditionOperator::BEGINS_WITH => $main_editor,
                    FilterConditionOperator::ENDS_WITH => $main_editor,
                    FilterConditionOperator::IS_LIKE => $main_editor,
                    FilterConditionOperator::IS_NOT_LIKE => $main_editor,
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
            if (GetCurrentUserPermissionsForPage('ADG2L_Produtos.ADG2L_MovimentacaoEstoque')->HasViewGrant() && $withDetails)
            {
            //
            // View column for ADG2L_Produtos_ADG2L_MovimentacaoEstoque detail
            //
            $column = new DetailColumn(array('idProduto'), 'ADG2L_Produtos.ADG2L_MovimentacaoEstoque', 'ADG2L_Produtos_ADG2L_MovimentacaoEstoque_handler', $this->dataset, 'ADG2 L Movimentacao Estoque');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('ADG2L_Produtos.ADG2L_VendaProdutos')->HasViewGrant() && $withDetails)
            {
            //
            // View column for ADG2L_Produtos_ADG2L_VendaProdutos detail
            //
            $column = new DetailColumn(array('idProduto'), 'ADG2L_Produtos.ADG2L_VendaProdutos', 'ADG2L_Produtos_ADG2L_VendaProdutos_handler', $this->dataset, 'ADG2 L Venda Produtos');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for idProduto field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for nomeCategoria field
            //
            $column = new TextViewColumn('idCategoria', 'idCategoria_nomeCategoria', 'Id Categoria', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for nomeFornecedor field
            //
            $column = new TextViewColumn('idFornecedor', 'idFornecedor_nomeFornecedor', 'Id Fornecedor', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for nomeProduto field
            //
            $column = new TextViewColumn('nomeProduto', 'nomeProduto', 'Nome Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for precoProduto field
            //
            $column = new NumberViewColumn('precoProduto', 'precoProduto', 'Preco Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for quantidadeEstoqueProduto field
            //
            $column = new NumberViewColumn('quantidadeEstoqueProduto', 'quantidadeEstoqueProduto', 'Quantidade Estoque Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for descricaoBebidas field
            //
            $column = new TextViewColumn('descricaoBebidas', 'descricaoBebidas', 'Descricao Bebidas', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for tipoUnidade field
            //
            $column = new TextViewColumn('tipoUnidade', 'tipoUnidade', 'Tipo Unidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for tamanhoUnidade field
            //
            $column = new NumberViewColumn('tamanhoUnidade', 'tamanhoUnidade', 'Tamanho Unidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for dataValidade field
            //
            $column = new DateTimeViewColumn('dataValidade', 'dataValidade', 'Data Validade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for dataCompraDoProduto field
            //
            $column = new DateTimeViewColumn('dataCompraDoProduto', 'dataCompraDoProduto', 'Data Compra Do Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for imagemProduto field
            //
            $column = new ExternalImageViewColumn('imagemProduto', 'imagemProduto', 'Imagem Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setSourcePrefixTemplate('fotos/');
            $column->setWidth('100');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for idProduto field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nomeCategoria field
            //
            $column = new TextViewColumn('idCategoria', 'idCategoria_nomeCategoria', 'Id Categoria', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nomeFornecedor field
            //
            $column = new TextViewColumn('idFornecedor', 'idFornecedor_nomeFornecedor', 'Id Fornecedor', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nomeProduto field
            //
            $column = new TextViewColumn('nomeProduto', 'nomeProduto', 'Nome Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for precoProduto field
            //
            $column = new NumberViewColumn('precoProduto', 'precoProduto', 'Preco Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for quantidadeEstoqueProduto field
            //
            $column = new NumberViewColumn('quantidadeEstoqueProduto', 'quantidadeEstoqueProduto', 'Quantidade Estoque Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for descricaoBebidas field
            //
            $column = new TextViewColumn('descricaoBebidas', 'descricaoBebidas', 'Descricao Bebidas', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tipoUnidade field
            //
            $column = new TextViewColumn('tipoUnidade', 'tipoUnidade', 'Tipo Unidade', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tamanhoUnidade field
            //
            $column = new NumberViewColumn('tamanhoUnidade', 'tamanhoUnidade', 'Tamanho Unidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for dataValidade field
            //
            $column = new DateTimeViewColumn('dataValidade', 'dataValidade', 'Data Validade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for dataCompraDoProduto field
            //
            $column = new DateTimeViewColumn('dataCompraDoProduto', 'dataCompraDoProduto', 'Data Compra Do Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for imagemProduto field
            //
            $column = new ExternalImageViewColumn('imagemProduto', 'imagemProduto', 'Imagem Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setSourcePrefixTemplate('fotos/');
            $column->setWidth('100');
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for idProduto field
            //
            $editor = new TextEdit('idproduto_edit');
            $editColumn = new CustomEditColumn('Id Produto', 'idProduto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idCategoria field
            //
            $editor = new DynamicCombobox('idcategoria_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Categorias`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCategoria', true, true, true),
                    new StringField('nomeCategoria', true)
                )
            );
            $lookupDataset->setOrderByField('nomeCategoria', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Categoria', 'idCategoria', 'idCategoria_nomeCategoria', 'edit_ADG2L_Produtos_idCategoria_search', $editor, $this->dataset, $lookupDataset, 'idCategoria', 'nomeCategoria', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idFornecedor field
            //
            $editor = new DynamicCombobox('idfornecedor_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Fornecedor`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idFornecedor', true, true, true),
                    new StringField('nomeFornecedor', true),
                    new StringField('contatoTel', true),
                    new StringField('CNPJ', true)
                )
            );
            $lookupDataset->setOrderByField('nomeFornecedor', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Fornecedor', 'idFornecedor', 'idFornecedor_nomeFornecedor', 'edit_ADG2L_Produtos_idFornecedor_search', $editor, $this->dataset, $lookupDataset, 'idFornecedor', 'nomeFornecedor', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nomeProduto field
            //
            $editor = new TextEdit('nomeproduto_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Nome Produto', 'nomeProduto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for precoProduto field
            //
            $editor = new TextEdit('precoproduto_edit');
            $editColumn = new CustomEditColumn('Preco Produto', 'precoProduto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for quantidadeEstoqueProduto field
            //
            $editor = new TextEdit('quantidadeestoqueproduto_edit');
            $editColumn = new CustomEditColumn('Quantidade Estoque Produto', 'quantidadeEstoqueProduto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for descricaoBebidas field
            //
            $editor = new TextAreaEdit('descricaobebidas_edit', 50, 8);
            $editColumn = new CustomEditColumn('Descricao Bebidas', 'descricaoBebidas', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipoUnidade field
            //
            $editor = new TextEdit('tipounidade_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Tipo Unidade', 'tipoUnidade', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tamanhoUnidade field
            //
            $editor = new TextEdit('tamanhounidade_edit');
            $editColumn = new CustomEditColumn('Tamanho Unidade', 'tamanhoUnidade', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for dataValidade field
            //
            $editor = new DateTimeEdit('datavalidade_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Data Validade', 'dataValidade', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for dataCompraDoProduto field
            //
            $editor = new DateTimeEdit('datacompradoproduto_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Data Compra Do Produto', 'dataCompraDoProduto', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for imagemProduto field
            //
            $editor = new ImageUploader('imagemproduto_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new UploadFileToFolderColumn('Imagem Produto', 'imagemProduto', $editor, $this->dataset, false, false, 'fotos/', '%random%.%original_file_extension%', $this->OnFileUpload, true);
            $editColumn->SetReplaceUploadedFileIfExist(true);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for idCategoria field
            //
            $editor = new DynamicCombobox('idcategoria_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Categorias`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCategoria', true, true, true),
                    new StringField('nomeCategoria', true)
                )
            );
            $lookupDataset->setOrderByField('nomeCategoria', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Categoria', 'idCategoria', 'idCategoria_nomeCategoria', 'multi_edit_ADG2L_Produtos_idCategoria_search', $editor, $this->dataset, $lookupDataset, 'idCategoria', 'nomeCategoria', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for idFornecedor field
            //
            $editor = new DynamicCombobox('idfornecedor_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Fornecedor`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idFornecedor', true, true, true),
                    new StringField('nomeFornecedor', true),
                    new StringField('contatoTel', true),
                    new StringField('CNPJ', true)
                )
            );
            $lookupDataset->setOrderByField('nomeFornecedor', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Fornecedor', 'idFornecedor', 'idFornecedor_nomeFornecedor', 'multi_edit_ADG2L_Produtos_idFornecedor_search', $editor, $this->dataset, $lookupDataset, 'idFornecedor', 'nomeFornecedor', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nomeProduto field
            //
            $editor = new TextEdit('nomeproduto_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Nome Produto', 'nomeProduto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for precoProduto field
            //
            $editor = new TextEdit('precoproduto_edit');
            $editColumn = new CustomEditColumn('Preco Produto', 'precoProduto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for quantidadeEstoqueProduto field
            //
            $editor = new TextEdit('quantidadeestoqueproduto_edit');
            $editColumn = new CustomEditColumn('Quantidade Estoque Produto', 'quantidadeEstoqueProduto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for descricaoBebidas field
            //
            $editor = new TextAreaEdit('descricaobebidas_edit', 50, 8);
            $editColumn = new CustomEditColumn('Descricao Bebidas', 'descricaoBebidas', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tipoUnidade field
            //
            $editor = new TextEdit('tipounidade_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Tipo Unidade', 'tipoUnidade', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tamanhoUnidade field
            //
            $editor = new TextEdit('tamanhounidade_edit');
            $editColumn = new CustomEditColumn('Tamanho Unidade', 'tamanhoUnidade', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for dataValidade field
            //
            $editor = new DateTimeEdit('datavalidade_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Data Validade', 'dataValidade', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for dataCompraDoProduto field
            //
            $editor = new DateTimeEdit('datacompradoproduto_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Data Compra Do Produto', 'dataCompraDoProduto', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for imagemProduto field
            //
            $editor = new ImageUploader('imagemproduto_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new UploadFileToFolderColumn('Imagem Produto', 'imagemProduto', $editor, $this->dataset, false, false, 'fotos/', '%random%.%original_file_extension%', $this->OnFileUpload, true);
            $editColumn->SetReplaceUploadedFileIfExist(true);
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
            $editor = new TextEdit('idproduto_edit');
            $editColumn = new CustomEditColumn('Id Produto', 'idProduto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idCategoria field
            //
            $editor = new DynamicCombobox('idcategoria_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Categorias`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCategoria', true, true, true),
                    new StringField('nomeCategoria', true)
                )
            );
            $lookupDataset->setOrderByField('nomeCategoria', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Categoria', 'idCategoria', 'idCategoria_nomeCategoria', 'insert_ADG2L_Produtos_idCategoria_search', $editor, $this->dataset, $lookupDataset, 'idCategoria', 'nomeCategoria', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for idFornecedor field
            //
            $editor = new DynamicCombobox('idfornecedor_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Fornecedor`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idFornecedor', true, true, true),
                    new StringField('nomeFornecedor', true),
                    new StringField('contatoTel', true),
                    new StringField('CNPJ', true)
                )
            );
            $lookupDataset->setOrderByField('nomeFornecedor', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Id Fornecedor', 'idFornecedor', 'idFornecedor_nomeFornecedor', 'insert_ADG2L_Produtos_idFornecedor_search', $editor, $this->dataset, $lookupDataset, 'idFornecedor', 'nomeFornecedor', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nomeProduto field
            //
            $editor = new TextEdit('nomeproduto_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Nome Produto', 'nomeProduto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for precoProduto field
            //
            $editor = new TextEdit('precoproduto_edit');
            $editColumn = new CustomEditColumn('Preco Produto', 'precoProduto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for quantidadeEstoqueProduto field
            //
            $editor = new TextEdit('quantidadeestoqueproduto_edit');
            $editColumn = new CustomEditColumn('Quantidade Estoque Produto', 'quantidadeEstoqueProduto', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for descricaoBebidas field
            //
            $editor = new TextAreaEdit('descricaobebidas_edit', 50, 8);
            $editColumn = new CustomEditColumn('Descricao Bebidas', 'descricaoBebidas', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipoUnidade field
            //
            $editor = new TextEdit('tipounidade_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Tipo Unidade', 'tipoUnidade', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tamanhoUnidade field
            //
            $editor = new TextEdit('tamanhounidade_edit');
            $editColumn = new CustomEditColumn('Tamanho Unidade', 'tamanhoUnidade', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for dataValidade field
            //
            $editor = new DateTimeEdit('datavalidade_edit', false, 'd-m-Y');
            $editColumn = new CustomEditColumn('Data Validade', 'dataValidade', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for dataCompraDoProduto field
            //
            $editor = new DateTimeEdit('datacompradoproduto_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Data Compra Do Produto', 'dataCompraDoProduto', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for imagemProduto field
            //
            $editor = new ImageUploader('imagemproduto_edit');
            $editor->SetShowImage(true);
            $editor->setAcceptableFileTypes('image/*');
            $editColumn = new UploadFileToFolderColumn('Imagem Produto', 'imagemProduto', $editor, $this->dataset, false, false, 'fotos/', '%random%.%original_file_extension%', $this->OnFileUpload, true);
            $editColumn->SetReplaceUploadedFileIfExist(true);
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
            $column = new NumberViewColumn('idProduto', 'idProduto', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nomeCategoria field
            //
            $column = new TextViewColumn('idCategoria', 'idCategoria_nomeCategoria', 'Id Categoria', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nomeFornecedor field
            //
            $column = new TextViewColumn('idFornecedor', 'idFornecedor_nomeFornecedor', 'Id Fornecedor', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nomeProduto field
            //
            $column = new TextViewColumn('nomeProduto', 'nomeProduto', 'Nome Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for precoProduto field
            //
            $column = new NumberViewColumn('precoProduto', 'precoProduto', 'Preco Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for quantidadeEstoqueProduto field
            //
            $column = new NumberViewColumn('quantidadeEstoqueProduto', 'quantidadeEstoqueProduto', 'Quantidade Estoque Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for descricaoBebidas field
            //
            $column = new TextViewColumn('descricaoBebidas', 'descricaoBebidas', 'Descricao Bebidas', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for tipoUnidade field
            //
            $column = new TextViewColumn('tipoUnidade', 'tipoUnidade', 'Tipo Unidade', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for tamanhoUnidade field
            //
            $column = new NumberViewColumn('tamanhoUnidade', 'tamanhoUnidade', 'Tamanho Unidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for dataValidade field
            //
            $column = new DateTimeViewColumn('dataValidade', 'dataValidade', 'Data Validade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddPrintColumn($column);
            
            //
            // View column for dataCompraDoProduto field
            //
            $column = new DateTimeViewColumn('dataCompraDoProduto', 'dataCompraDoProduto', 'Data Compra Do Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for imagemProduto field
            //
            $column = new ExternalImageViewColumn('imagemProduto', 'imagemProduto', 'Imagem Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setSourcePrefixTemplate('fotos/');
            $column->setWidth('100');
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for idProduto field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for nomeCategoria field
            //
            $column = new TextViewColumn('idCategoria', 'idCategoria_nomeCategoria', 'Id Categoria', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nomeFornecedor field
            //
            $column = new TextViewColumn('idFornecedor', 'idFornecedor_nomeFornecedor', 'Id Fornecedor', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nomeProduto field
            //
            $column = new TextViewColumn('nomeProduto', 'nomeProduto', 'Nome Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for precoProduto field
            //
            $column = new NumberViewColumn('precoProduto', 'precoProduto', 'Preco Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for quantidadeEstoqueProduto field
            //
            $column = new NumberViewColumn('quantidadeEstoqueProduto', 'quantidadeEstoqueProduto', 'Quantidade Estoque Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for descricaoBebidas field
            //
            $column = new TextViewColumn('descricaoBebidas', 'descricaoBebidas', 'Descricao Bebidas', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for tipoUnidade field
            //
            $column = new TextViewColumn('tipoUnidade', 'tipoUnidade', 'Tipo Unidade', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for tamanhoUnidade field
            //
            $column = new NumberViewColumn('tamanhoUnidade', 'tamanhoUnidade', 'Tamanho Unidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for dataValidade field
            //
            $column = new DateTimeViewColumn('dataValidade', 'dataValidade', 'Data Validade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddExportColumn($column);
            
            //
            // View column for dataCompraDoProduto field
            //
            $column = new DateTimeViewColumn('dataCompraDoProduto', 'dataCompraDoProduto', 'Data Compra Do Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for imagemProduto field
            //
            $column = new ExternalImageViewColumn('imagemProduto', 'imagemProduto', 'Imagem Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setSourcePrefixTemplate('fotos/');
            $column->setWidth('100');
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for idProduto field
            //
            $column = new NumberViewColumn('idProduto', 'idProduto', 'Id Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for nomeCategoria field
            //
            $column = new TextViewColumn('idCategoria', 'idCategoria_nomeCategoria', 'Id Categoria', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nomeFornecedor field
            //
            $column = new TextViewColumn('idFornecedor', 'idFornecedor_nomeFornecedor', 'Id Fornecedor', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nomeProduto field
            //
            $column = new TextViewColumn('nomeProduto', 'nomeProduto', 'Nome Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for precoProduto field
            //
            $column = new NumberViewColumn('precoProduto', 'precoProduto', 'Preco Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for quantidadeEstoqueProduto field
            //
            $column = new NumberViewColumn('quantidadeEstoqueProduto', 'quantidadeEstoqueProduto', 'Quantidade Estoque Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for descricaoBebidas field
            //
            $column = new TextViewColumn('descricaoBebidas', 'descricaoBebidas', 'Descricao Bebidas', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for tipoUnidade field
            //
            $column = new TextViewColumn('tipoUnidade', 'tipoUnidade', 'Tipo Unidade', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for tamanhoUnidade field
            //
            $column = new NumberViewColumn('tamanhoUnidade', 'tamanhoUnidade', 'Tamanho Unidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for dataValidade field
            //
            $column = new DateTimeViewColumn('dataValidade', 'dataValidade', 'Data Validade', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y');
            $grid->AddCompareColumn($column);
            
            //
            // View column for dataCompraDoProduto field
            //
            $column = new DateTimeViewColumn('dataCompraDoProduto', 'dataCompraDoProduto', 'Data Compra Do Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for imagemProduto field
            //
            $column = new ExternalImageViewColumn('imagemProduto', 'imagemProduto', 'Imagem Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setSourcePrefixTemplate('fotos/');
            $column->setWidth('100');
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
    
        function CreateMasterDetailRecordGrid()
        {
            $result = new Grid($this, $this->dataset);
            
            $this->AddFieldColumns($result, false);
            $this->AddPrintColumns($result);
            $this->AddExportColumns($result);
            
            $result->SetAllowDeleteSelected(false);
            $result->SetShowUpdateLink(false);
            $result->SetShowKeyColumnsImagesInHeader(false);
            $result->SetViewMode(ViewMode::TABLE);
            $result->setEnableRuntimeCustomization(false);
            $result->setTableBordered(true);
            $result->setTableCondensed(true);
            
            $this->setupGridColumnGroup($result);
            $this->attachGridEventHandlers($result);
            
            return $result;
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
            $detailPage = new ADG2L_Produtos_ADG2L_MovimentacaoEstoquePage('ADG2L_Produtos_ADG2L_MovimentacaoEstoque', $this, array('idProduto'), array('idProduto'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('ADG2L_Produtos.ADG2L_MovimentacaoEstoque'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('ADG2L_Produtos.ADG2L_MovimentacaoEstoque'));
            $detailPage->SetHttpHandlerName('ADG2L_Produtos_ADG2L_MovimentacaoEstoque_handler');
            $handler = new PageHTTPHandler('ADG2L_Produtos_ADG2L_MovimentacaoEstoque_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new ADG2L_Produtos_ADG2L_VendaProdutosPage('ADG2L_Produtos_ADG2L_VendaProdutos', $this, array('idProduto'), array('idProduto'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('ADG2L_Produtos.ADG2L_VendaProdutos'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('ADG2L_Produtos.ADG2L_VendaProdutos'));
            $detailPage->SetHttpHandlerName('ADG2L_Produtos_ADG2L_VendaProdutos_handler');
            $handler = new PageHTTPHandler('ADG2L_Produtos_ADG2L_VendaProdutos_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Categorias`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCategoria', true, true, true),
                    new StringField('nomeCategoria', true)
                )
            );
            $lookupDataset->setOrderByField('nomeCategoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_ADG2L_Produtos_idCategoria_search', 'idCategoria', 'nomeCategoria', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Fornecedor`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idFornecedor', true, true, true),
                    new StringField('nomeFornecedor', true),
                    new StringField('contatoTel', true),
                    new StringField('CNPJ', true)
                )
            );
            $lookupDataset->setOrderByField('nomeFornecedor', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_ADG2L_Produtos_idFornecedor_search', 'idFornecedor', 'nomeFornecedor', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Categorias`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCategoria', true, true, true),
                    new StringField('nomeCategoria', true)
                )
            );
            $lookupDataset->setOrderByField('nomeCategoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_ADG2L_Produtos_idCategoria_search', 'idCategoria', 'nomeCategoria', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Fornecedor`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idFornecedor', true, true, true),
                    new StringField('nomeFornecedor', true),
                    new StringField('contatoTel', true),
                    new StringField('CNPJ', true)
                )
            );
            $lookupDataset->setOrderByField('nomeFornecedor', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_ADG2L_Produtos_idFornecedor_search', 'idFornecedor', 'nomeFornecedor', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Categorias`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCategoria', true, true, true),
                    new StringField('nomeCategoria', true)
                )
            );
            $lookupDataset->setOrderByField('nomeCategoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_ADG2L_Produtos_idCategoria_search', 'idCategoria', 'nomeCategoria', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Fornecedor`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idFornecedor', true, true, true),
                    new StringField('nomeFornecedor', true),
                    new StringField('contatoTel', true),
                    new StringField('CNPJ', true)
                )
            );
            $lookupDataset->setOrderByField('nomeFornecedor', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_ADG2L_Produtos_idFornecedor_search', 'idFornecedor', 'nomeFornecedor', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Categorias`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idCategoria', true, true, true),
                    new StringField('nomeCategoria', true)
                )
            );
            $lookupDataset->setOrderByField('nomeCategoria', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_ADG2L_Produtos_idCategoria_search', 'idCategoria', 'nomeCategoria', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Fornecedor`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idFornecedor', true, true, true),
                    new StringField('nomeFornecedor', true),
                    new StringField('contatoTel', true),
                    new StringField('CNPJ', true)
                )
            );
            $lookupDataset->setOrderByField('nomeFornecedor', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_ADG2L_Produtos_idFornecedor_search', 'idFornecedor', 'nomeFornecedor', null, 20);
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
        $Page = new ADG2L_ProdutosPage("ADG2L_Produtos", "ADG2L_Produtos.php", GetCurrentUserPermissionsForPage("ADG2L_Produtos"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("ADG2L_Produtos"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
