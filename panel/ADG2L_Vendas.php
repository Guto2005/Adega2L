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
    
    
    
    class ADG2L_Vendas_ADG2L_FluxoCaixaPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('ADG2 L Fluxo Caixa');
            $this->SetMenuLabel('ADG2 L Fluxo Caixa');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_FluxoCaixa`');
            $this->dataset->addFields(
                array(
                    new IntegerField('idTransacao', true, true, true),
                    new StringField('tipoTransacao', true),
                    new IntegerField('valor', true),
                    new StringField('descricao'),
                    new DateTimeField('dataTransacao', true),
                    new IntegerField('idVenda')
                )
            );
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
                new FilterColumn($this->dataset, 'idTransacao', 'idTransacao', 'Id Transacao'),
                new FilterColumn($this->dataset, 'tipoTransacao', 'tipoTransacao', 'Tipo Transacao'),
                new FilterColumn($this->dataset, 'valor', 'valor', 'Valor'),
                new FilterColumn($this->dataset, 'descricao', 'descricao', 'Descricao'),
                new FilterColumn($this->dataset, 'dataTransacao', 'dataTransacao', 'Data Transacao'),
                new FilterColumn($this->dataset, 'idVenda', 'idVenda_idUsuario', 'Id Venda')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['idTransacao'])
                ->addColumn($columns['tipoTransacao'])
                ->addColumn($columns['valor'])
                ->addColumn($columns['descricao'])
                ->addColumn($columns['dataTransacao'])
                ->addColumn($columns['idVenda']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('dataTransacao')
                ->setOptionsFor('idVenda');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('idtransacao_edit');
            
            $filterBuilder->addColumn(
                $columns['idTransacao'],
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
            
            $main_editor = new TextEdit('tipotransacao_edit');
            $main_editor->SetMaxLength(10);
            
            $filterBuilder->addColumn(
                $columns['tipoTransacao'],
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
            
            $main_editor = new TextEdit('valor_edit');
            
            $filterBuilder->addColumn(
                $columns['valor'],
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
            
            $main_editor = new DateTimeEdit('datatransacao_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['dataTransacao'],
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
            
            $main_editor = new DynamicCombobox('idvenda_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_ADG2L_Vendas_ADG2L_FluxoCaixa_idVenda_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idVenda', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_ADG2L_Vendas_ADG2L_FluxoCaixa_idVenda_search');
            
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
            // View column for idTransacao field
            //
            $column = new NumberViewColumn('idTransacao', 'idTransacao', 'Id Transacao', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for tipoTransacao field
            //
            $column = new TextViewColumn('tipoTransacao', 'tipoTransacao', 'Tipo Transacao', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for valor field
            //
            $column = new NumberViewColumn('valor', 'valor', 'Valor', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
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
            //
            // View column for dataTransacao field
            //
            $column = new DateTimeViewColumn('dataTransacao', 'dataTransacao', 'Data Transacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
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
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for idTransacao field
            //
            $column = new NumberViewColumn('idTransacao', 'idTransacao', 'Id Transacao', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tipoTransacao field
            //
            $column = new TextViewColumn('tipoTransacao', 'tipoTransacao', 'Tipo Transacao', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for valor field
            //
            $column = new NumberViewColumn('valor', 'valor', 'Valor', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for descricao field
            //
            $column = new TextViewColumn('descricao', 'descricao', 'Descricao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for dataTransacao field
            //
            $column = new DateTimeViewColumn('dataTransacao', 'dataTransacao', 'Data Transacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
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
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for idTransacao field
            //
            $editor = new TextEdit('idtransacao_edit');
            $editColumn = new CustomEditColumn('Id Transacao', 'idTransacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipoTransacao field
            //
            $editor = new TextEdit('tipotransacao_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Tipo Transacao', 'tipoTransacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for valor field
            //
            $editor = new TextEdit('valor_edit');
            $editColumn = new CustomEditColumn('Valor', 'valor', $editor, $this->dataset);
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
            
            //
            // Edit column for dataTransacao field
            //
            $editor = new DateTimeEdit('datatransacao_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Data Transacao', 'dataTransacao', $editor, $this->dataset);
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
            $editColumn = new DynamicLookupEditColumn('Id Venda', 'idVenda', 'idVenda_idUsuario', 'edit_ADG2L_Vendas_ADG2L_FluxoCaixa_idVenda_search', $editor, $this->dataset, $lookupDataset, 'idVenda', 'idUsuario', '');
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for tipoTransacao field
            //
            $editor = new TextEdit('tipotransacao_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Tipo Transacao', 'tipoTransacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for valor field
            //
            $editor = new TextEdit('valor_edit');
            $editColumn = new CustomEditColumn('Valor', 'valor', $editor, $this->dataset);
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
            
            //
            // Edit column for dataTransacao field
            //
            $editor = new DateTimeEdit('datatransacao_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Data Transacao', 'dataTransacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
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
            $editColumn = new DynamicLookupEditColumn('Id Venda', 'idVenda', 'idVenda_idUsuario', 'multi_edit_ADG2L_Vendas_ADG2L_FluxoCaixa_idVenda_search', $editor, $this->dataset, $lookupDataset, 'idVenda', 'idUsuario', '');
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
            // Edit column for idTransacao field
            //
            $editor = new TextEdit('idtransacao_edit');
            $editColumn = new CustomEditColumn('Id Transacao', 'idTransacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipoTransacao field
            //
            $editor = new TextEdit('tipotransacao_edit');
            $editor->SetMaxLength(10);
            $editColumn = new CustomEditColumn('Tipo Transacao', 'tipoTransacao', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for valor field
            //
            $editor = new TextEdit('valor_edit');
            $editColumn = new CustomEditColumn('Valor', 'valor', $editor, $this->dataset);
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
            
            //
            // Edit column for dataTransacao field
            //
            $editor = new DateTimeEdit('datatransacao_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Data Transacao', 'dataTransacao', $editor, $this->dataset);
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
            $editColumn = new DynamicLookupEditColumn('Id Venda', 'idVenda', 'idVenda_idUsuario', 'insert_ADG2L_Vendas_ADG2L_FluxoCaixa_idVenda_search', $editor, $this->dataset, $lookupDataset, 'idVenda', 'idUsuario', '');
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
            // View column for idTransacao field
            //
            $column = new NumberViewColumn('idTransacao', 'idTransacao', 'Id Transacao', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for tipoTransacao field
            //
            $column = new TextViewColumn('tipoTransacao', 'tipoTransacao', 'Tipo Transacao', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for valor field
            //
            $column = new NumberViewColumn('valor', 'valor', 'Valor', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for descricao field
            //
            $column = new TextViewColumn('descricao', 'descricao', 'Descricao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for dataTransacao field
            //
            $column = new DateTimeViewColumn('dataTransacao', 'dataTransacao', 'Data Transacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
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
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for idTransacao field
            //
            $column = new NumberViewColumn('idTransacao', 'idTransacao', 'Id Transacao', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for tipoTransacao field
            //
            $column = new TextViewColumn('tipoTransacao', 'tipoTransacao', 'Tipo Transacao', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for valor field
            //
            $column = new NumberViewColumn('valor', 'valor', 'Valor', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for descricao field
            //
            $column = new TextViewColumn('descricao', 'descricao', 'Descricao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for dataTransacao field
            //
            $column = new DateTimeViewColumn('dataTransacao', 'dataTransacao', 'Data Transacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
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
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for idTransacao field
            //
            $column = new NumberViewColumn('idTransacao', 'idTransacao', 'Id Transacao', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for tipoTransacao field
            //
            $column = new TextViewColumn('tipoTransacao', 'tipoTransacao', 'Tipo Transacao', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for valor field
            //
            $column = new NumberViewColumn('valor', 'valor', 'Valor', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for descricao field
            //
            $column = new TextViewColumn('descricao', 'descricao', 'Descricao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for dataTransacao field
            //
            $column = new DateTimeViewColumn('dataTransacao', 'dataTransacao', 'Data Transacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
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
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_ADG2L_Vendas_ADG2L_FluxoCaixa_idVenda_search', 'idVenda', 'idUsuario', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_ADG2L_Vendas_ADG2L_FluxoCaixa_idVenda_search', 'idVenda', 'idUsuario', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_ADG2L_Vendas_ADG2L_FluxoCaixa_idVenda_search', 'idVenda', 'idUsuario', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_ADG2L_Vendas_ADG2L_FluxoCaixa_idVenda_search', 'idVenda', 'idUsuario', null, 20);
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
    
    
    
    class ADG2L_Vendas_ADG2L_VendaProdutosPage extends DetailPage
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
            $main_editor->SetHandlerName('filter_builder_ADG2L_Vendas_ADG2L_VendaProdutos_idProduto_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idProduto', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_ADG2L_Vendas_ADG2L_VendaProdutos_idProduto_search');
            
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
            $main_editor->SetHandlerName('filter_builder_ADG2L_Vendas_ADG2L_VendaProdutos_idVenda_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idVenda', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_ADG2L_Vendas_ADG2L_VendaProdutos_idVenda_search');
            
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
            $editColumn = new DynamicLookupEditColumn('Id Produto', 'idProduto', 'idProduto_idCategoria', 'edit_ADG2L_Vendas_ADG2L_VendaProdutos_idProduto_search', $editor, $this->dataset, $lookupDataset, 'idProduto', 'idCategoria', '');
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
            $editColumn = new DynamicLookupEditColumn('Id Venda', 'idVenda', 'idVenda_idUsuario', 'edit_ADG2L_Vendas_ADG2L_VendaProdutos_idVenda_search', $editor, $this->dataset, $lookupDataset, 'idVenda', 'idUsuario', '');
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
            $editColumn = new DynamicLookupEditColumn('Id Produto', 'idProduto', 'idProduto_idCategoria', 'insert_ADG2L_Vendas_ADG2L_VendaProdutos_idProduto_search', $editor, $this->dataset, $lookupDataset, 'idProduto', 'idCategoria', '');
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
            $editColumn = new DynamicLookupEditColumn('Id Venda', 'idVenda', 'idVenda_idUsuario', 'insert_ADG2L_Vendas_ADG2L_VendaProdutos_idVenda_search', $editor, $this->dataset, $lookupDataset, 'idVenda', 'idUsuario', '');
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
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_ADG2L_Vendas_ADG2L_VendaProdutos_idProduto_search', 'idProduto', 'idCategoria', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_ADG2L_Vendas_ADG2L_VendaProdutos_idVenda_search', 'idVenda', 'idUsuario', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_ADG2L_Vendas_ADG2L_VendaProdutos_idProduto_search', 'idProduto', 'idCategoria', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_ADG2L_Vendas_ADG2L_VendaProdutos_idVenda_search', 'idVenda', 'idUsuario', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_ADG2L_Vendas_ADG2L_VendaProdutos_idProduto_search', 'idProduto', 'idCategoria', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_ADG2L_Vendas_ADG2L_VendaProdutos_idVenda_search', 'idVenda', 'idUsuario', null, 20);
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
    
    class ADG2L_Vendas_idUsuarioModalViewPage extends ViewBasedPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Usuarios`');
            $this->dataset->addFields(
                array(
                    new IntegerField('idUsuario', true, true, true),
                    new StringField('nomeUsuario', true),
                    new StringField('senhaUsuario', true),
                    new StringField('emailUsuario', true),
                    new StringField('cpfUsuario', true),
                    new StringField('tipoLogradouro', true),
                    new StringField('nomeLogradouro', true),
                    new StringField('numeroLogradouro', true),
                    new StringField('complementoLogradouro'),
                    new StringField('bairro', true),
                    new StringField('cidade', true),
                    new StringField('cep', true),
                    new StringField('DDI', true),
                    new StringField('DDD', true),
                    new StringField('numeroTelefone'),
                    new DateTimeField('dataNasc'),
                    new StringField('token_recuperacao')
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for idUsuario field
            //
            $column = new NumberViewColumn('idUsuario', 'idUsuario', 'Id Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nomeUsuario field
            //
            $column = new TextViewColumn('nomeUsuario', 'nomeUsuario', 'Nome Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for senhaUsuario field
            //
            $column = new TextViewColumn('senhaUsuario', 'senhaUsuario', 'Senha Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for emailUsuario field
            //
            $column = new TextViewColumn('emailUsuario', 'emailUsuario', 'Email Usuario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cpfUsuario field
            //
            $column = new TextViewColumn('cpfUsuario', 'cpfUsuario', 'Cpf Usuario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for tipoLogradouro field
            //
            $column = new TextViewColumn('tipoLogradouro', 'tipoLogradouro', 'Tipo Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nomeLogradouro field
            //
            $column = new TextViewColumn('nomeLogradouro', 'nomeLogradouro', 'Nome Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for numeroLogradouro field
            //
            $column = new TextViewColumn('numeroLogradouro', 'numeroLogradouro', 'Numero Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for complementoLogradouro field
            //
            $column = new TextViewColumn('complementoLogradouro', 'complementoLogradouro', 'Complemento Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for bairro field
            //
            $column = new TextViewColumn('bairro', 'bairro', 'Bairro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cidade field
            //
            $column = new TextViewColumn('cidade', 'cidade', 'Cidade', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cep field
            //
            $column = new TextViewColumn('cep', 'cep', 'Cep', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for DDI field
            //
            $column = new TextViewColumn('DDI', 'DDI', 'DDI', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for DDD field
            //
            $column = new TextViewColumn('DDD', 'DDD', 'DDD', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for numeroTelefone field
            //
            $column = new TextViewColumn('numeroTelefone', 'numeroTelefone', 'Numero Telefone', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for dataNasc field
            //
            $column = new DateTimeViewColumn('dataNasc', 'dataNasc', 'Data Nasc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for token_recuperacao field
            //
            $column = new TextViewColumn('token_recuperacao', 'token_recuperacao', 'Token Recuperacao', $this->dataset);
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
    
    class ADG2L_Vendas_idUsuarioNestedPage extends NestedFormPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Usuarios`');
            $this->dataset->addFields(
                array(
                    new IntegerField('idUsuario', true, true, true),
                    new StringField('nomeUsuario', true),
                    new StringField('senhaUsuario', true),
                    new StringField('emailUsuario', true),
                    new StringField('cpfUsuario', true),
                    new StringField('tipoLogradouro', true),
                    new StringField('nomeLogradouro', true),
                    new StringField('numeroLogradouro', true),
                    new StringField('complementoLogradouro'),
                    new StringField('bairro', true),
                    new StringField('cidade', true),
                    new StringField('cep', true),
                    new StringField('DDI', true),
                    new StringField('DDD', true),
                    new StringField('numeroTelefone'),
                    new DateTimeField('dataNasc'),
                    new StringField('token_recuperacao')
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for nomeUsuario field
            //
            $editor = new TextEdit('nomeusuario_edit');
            $editor->SetMaxLength(80);
            $editColumn = new CustomEditColumn('Nome Usuario', 'nomeUsuario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for senhaUsuario field
            //
            $editor = new TextAreaEdit('senhausuario_edit', 50, 8);
            $editColumn = new CustomEditColumn('Senha Usuario', 'senhaUsuario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for emailUsuario field
            //
            $editor = new TextEdit('emailusuario_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Email Usuario', 'emailUsuario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cpfUsuario field
            //
            $editor = new TextEdit('cpfusuario_edit');
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('Cpf Usuario', 'cpfUsuario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for tipoLogradouro field
            //
            $editor = new TextEdit('tipologradouro_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Tipo Logradouro', 'tipoLogradouro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for nomeLogradouro field
            //
            $editor = new TextEdit('nomelogradouro_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Nome Logradouro', 'nomeLogradouro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for numeroLogradouro field
            //
            $editor = new TextEdit('numerologradouro_edit');
            $editor->SetMaxLength(6);
            $editColumn = new CustomEditColumn('Numero Logradouro', 'numeroLogradouro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for complementoLogradouro field
            //
            $editor = new TextAreaEdit('complementologradouro_edit', 50, 8);
            $editColumn = new CustomEditColumn('Complemento Logradouro', 'complementoLogradouro', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for bairro field
            //
            $editor = new TextEdit('bairro_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Bairro', 'bairro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cidade field
            //
            $editor = new TextEdit('cidade_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Cidade', 'cidade', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cep field
            //
            $editor = new TextEdit('cep_edit');
            $editor->SetMaxLength(8);
            $editColumn = new CustomEditColumn('Cep', 'cep', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for DDI field
            //
            $editor = new TextEdit('ddi_edit');
            $editor->SetMaxLength(3);
            $editColumn = new CustomEditColumn('DDI', 'DDI', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for DDD field
            //
            $editor = new TextEdit('ddd_edit');
            $editor->SetMaxLength(3);
            $editColumn = new CustomEditColumn('DDD', 'DDD', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for numeroTelefone field
            //
            $editor = new TextEdit('numerotelefone_edit');
            $editor->SetMaxLength(9);
            $editColumn = new CustomEditColumn('Numero Telefone', 'numeroTelefone', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for dataNasc field
            //
            $editor = new DateTimeEdit('datanasc_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Data Nasc', 'dataNasc', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for token_recuperacao field
            //
            $editor = new TextAreaEdit('token_recuperacao_edit', 50, 8);
            $editColumn = new CustomEditColumn('Token Recuperacao', 'token_recuperacao', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
    
    
    
    class ADG2L_VendasPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('ADG2 L Vendas');
            $this->SetMenuLabel('Vendas');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Vendas`');
            $this->dataset->addFields(
                array(
                    new IntegerField('idVenda', true, true, true),
                    new IntegerField('idUsuario', true),
                    new DateTimeField('dataVenda', true),
                    new IntegerField('valorTotalVenda', true),
                    new StringField('formaDePagamento', true)
                )
            );
            $this->dataset->AddLookupField('idUsuario', 'ADG2L_Usuarios', new IntegerField('idUsuario'), new StringField('nomeUsuario', false, false, false, false, 'idUsuario_nomeUsuario', 'idUsuario_nomeUsuario_ADG2L_Usuarios'), 'idUsuario_nomeUsuario_ADG2L_Usuarios');
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
                new FilterColumn($this->dataset, 'idVenda', 'idVenda', 'Id Venda'),
                new FilterColumn($this->dataset, 'idUsuario', 'idUsuario_nomeUsuario', 'NomeUsuario'),
                new FilterColumn($this->dataset, 'dataVenda', 'dataVenda', 'Data Venda'),
                new FilterColumn($this->dataset, 'valorTotalVenda', 'valorTotalVenda', 'Valor Total Venda'),
                new FilterColumn($this->dataset, 'formaDePagamento', 'formaDePagamento', 'Forma De Pagamento')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['idUsuario'])
                ->addColumn($columns['dataVenda'])
                ->addColumn($columns['valorTotalVenda'])
                ->addColumn($columns['formaDePagamento']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('idUsuario')
                ->setOptionsFor('dataVenda');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new DynamicCombobox('idusuario_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_ADG2L_Vendas_idUsuario_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idUsuario', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_ADG2L_Vendas_idUsuario_search');
            
            $text_editor = new TextEdit('idUsuario');
            
            $filterBuilder->addColumn(
                $columns['idUsuario'],
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
            
            $main_editor = new DateTimeEdit('datavenda_edit', false, 'Y-m-d H:i:s');
            
            $filterBuilder->addColumn(
                $columns['dataVenda'],
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
            
            $main_editor = new TextEdit('valortotalvenda_edit');
            
            $filterBuilder->addColumn(
                $columns['valorTotalVenda'],
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
            
            $main_editor = new TextEdit('formadepagamento_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['formaDePagamento'],
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
            if (GetCurrentUserPermissionsForPage('ADG2L_Vendas.ADG2L_FluxoCaixa')->HasViewGrant() && $withDetails)
            {
            //
            // View column for ADG2L_Vendas_ADG2L_FluxoCaixa detail
            //
            $column = new DetailColumn(array('idVenda'), 'ADG2L_Vendas.ADG2L_FluxoCaixa', 'ADG2L_Vendas_ADG2L_FluxoCaixa_handler', $this->dataset, 'ADG2 L Fluxo Caixa');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            if (GetCurrentUserPermissionsForPage('ADG2L_Vendas.ADG2L_VendaProdutos')->HasViewGrant() && $withDetails)
            {
            //
            // View column for ADG2L_Vendas_ADG2L_VendaProdutos detail
            //
            $column = new DetailColumn(array('idVenda'), 'ADG2L_Vendas.ADG2L_VendaProdutos', 'ADG2L_Vendas_ADG2L_VendaProdutos_handler', $this->dataset, 'ADG2 L Venda Produtos');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for idVenda field
            //
            $column = new NumberViewColumn('idVenda', 'idVenda', 'Id Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for nomeUsuario field
            //
            $column = new TextViewColumn('idUsuario', 'idUsuario_nomeUsuario', 'NomeUsuario', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(ADG2L_Vendas_idUsuarioModalViewPage::getHandlerName());
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for dataVenda field
            //
            $column = new DateTimeViewColumn('dataVenda', 'dataVenda', 'Data Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for valorTotalVenda field
            //
            $column = new NumberViewColumn('valorTotalVenda', 'valorTotalVenda', 'Valor Total Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for formaDePagamento field
            //
            $column = new TextViewColumn('formaDePagamento', 'formaDePagamento', 'Forma De Pagamento', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for nomeUsuario field
            //
            $column = new TextViewColumn('idUsuario', 'idUsuario_nomeUsuario', 'NomeUsuario', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(ADG2L_Vendas_idUsuarioModalViewPage::getHandlerName());
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for dataVenda field
            //
            $column = new DateTimeViewColumn('dataVenda', 'dataVenda', 'Data Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for valorTotalVenda field
            //
            $column = new NumberViewColumn('valorTotalVenda', 'valorTotalVenda', 'Valor Total Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for formaDePagamento field
            //
            $column = new TextViewColumn('formaDePagamento', 'formaDePagamento', 'Forma De Pagamento', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for idVenda field
            //
            $editor = new TextEdit('idvenda_edit');
            $editColumn = new CustomEditColumn('Id Venda', 'idVenda', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for idUsuario field
            //
            $editor = new DynamicCombobox('idusuario_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idUsuario', true, true, true),
                    new StringField('nomeUsuario', true),
                    new StringField('senhaUsuario', true),
                    new StringField('emailUsuario', true),
                    new StringField('cpfUsuario', true),
                    new StringField('tipoLogradouro', true),
                    new StringField('nomeLogradouro', true),
                    new StringField('numeroLogradouro', true),
                    new StringField('complementoLogradouro'),
                    new StringField('bairro', true),
                    new StringField('cidade', true),
                    new StringField('cep', true),
                    new StringField('DDI', true),
                    new StringField('DDD', true),
                    new StringField('numeroTelefone'),
                    new DateTimeField('dataNasc'),
                    new StringField('token_recuperacao')
                )
            );
            $lookupDataset->setOrderByField('nomeUsuario', 'ASC');
            $editColumn = new DynamicLookupEditColumn('NomeUsuario', 'idUsuario', 'idUsuario_nomeUsuario', 'edit_ADG2L_Vendas_idUsuario_search', $editor, $this->dataset, $lookupDataset, 'idUsuario', 'nomeUsuario', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(ADG2L_Vendas_idUsuarioNestedPage::getNestedInsertHandlerName())
            );
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for dataVenda field
            //
            $editor = new DateTimeEdit('datavenda_edit', false, 'Y-m-d H:i:s');
            $editColumn = new CustomEditColumn('Data Venda', 'dataVenda', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for valorTotalVenda field
            //
            $editor = new TextEdit('valortotalvenda_edit');
            $editColumn = new CustomEditColumn('Valor Total Venda', 'valorTotalVenda', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for formaDePagamento field
            //
            $editor = new TextEdit('formadepagamento_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Forma De Pagamento', 'formaDePagamento', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
        {
            //
            // Edit column for idUsuario field
            //
            $editor = new DynamicCombobox('idusuario_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idUsuario', true, true, true),
                    new StringField('nomeUsuario', true),
                    new StringField('senhaUsuario', true),
                    new StringField('emailUsuario', true),
                    new StringField('cpfUsuario', true),
                    new StringField('tipoLogradouro', true),
                    new StringField('nomeLogradouro', true),
                    new StringField('numeroLogradouro', true),
                    new StringField('complementoLogradouro'),
                    new StringField('bairro', true),
                    new StringField('cidade', true),
                    new StringField('cep', true),
                    new StringField('DDI', true),
                    new StringField('DDD', true),
                    new StringField('numeroTelefone'),
                    new DateTimeField('dataNasc'),
                    new StringField('token_recuperacao')
                )
            );
            $lookupDataset->setOrderByField('nomeUsuario', 'ASC');
            $editColumn = new DynamicLookupEditColumn('NomeUsuario', 'idUsuario', 'idUsuario_nomeUsuario', 'multi_edit_ADG2L_Vendas_idUsuario_search', $editor, $this->dataset, $lookupDataset, 'idUsuario', 'nomeUsuario', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(ADG2L_Vendas_idUsuarioNestedPage::getNestedInsertHandlerName())
            );
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for dataVenda field
            //
            $editor = new DateTimeEdit('datavenda_edit', false, 'Y-m-d H:i:s');
            $editColumn = new CustomEditColumn('Data Venda', 'dataVenda', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for valorTotalVenda field
            //
            $editor = new TextEdit('valortotalvenda_edit');
            $editColumn = new CustomEditColumn('Valor Total Venda', 'valorTotalVenda', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for formaDePagamento field
            //
            $editor = new TextEdit('formadepagamento_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Forma De Pagamento', 'formaDePagamento', $editor, $this->dataset);
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
            // Edit column for idUsuario field
            //
            $editor = new DynamicCombobox('idusuario_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idUsuario', true, true, true),
                    new StringField('nomeUsuario', true),
                    new StringField('senhaUsuario', true),
                    new StringField('emailUsuario', true),
                    new StringField('cpfUsuario', true),
                    new StringField('tipoLogradouro', true),
                    new StringField('nomeLogradouro', true),
                    new StringField('numeroLogradouro', true),
                    new StringField('complementoLogradouro'),
                    new StringField('bairro', true),
                    new StringField('cidade', true),
                    new StringField('cep', true),
                    new StringField('DDI', true),
                    new StringField('DDD', true),
                    new StringField('numeroTelefone'),
                    new DateTimeField('dataNasc'),
                    new StringField('token_recuperacao')
                )
            );
            $lookupDataset->setOrderByField('nomeUsuario', 'ASC');
            $editColumn = new DynamicLookupEditColumn('NomeUsuario', 'idUsuario', 'idUsuario_nomeUsuario', 'insert_ADG2L_Vendas_idUsuario_search', $editor, $this->dataset, $lookupDataset, 'idUsuario', 'nomeUsuario', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(ADG2L_Vendas_idUsuarioNestedPage::getNestedInsertHandlerName())
            );
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for dataVenda field
            //
            $editor = new DateTimeEdit('datavenda_edit', false, 'Y-m-d H:i:s');
            $editColumn = new CustomEditColumn('Data Venda', 'dataVenda', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for valorTotalVenda field
            //
            $editor = new TextEdit('valortotalvenda_edit');
            $editColumn = new CustomEditColumn('Valor Total Venda', 'valorTotalVenda', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for formaDePagamento field
            //
            $editor = new TextEdit('formadepagamento_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Forma De Pagamento', 'formaDePagamento', $editor, $this->dataset);
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
            // View column for nomeUsuario field
            //
            $column = new TextViewColumn('idUsuario', 'idUsuario_nomeUsuario', 'NomeUsuario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for dataVenda field
            //
            $column = new DateTimeViewColumn('dataVenda', 'dataVenda', 'Data Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for valorTotalVenda field
            //
            $column = new NumberViewColumn('valorTotalVenda', 'valorTotalVenda', 'Valor Total Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddPrintColumn($column);
            
            //
            // View column for formaDePagamento field
            //
            $column = new TextViewColumn('formaDePagamento', 'formaDePagamento', 'Forma De Pagamento', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for nomeUsuario field
            //
            $column = new TextViewColumn('idUsuario', 'idUsuario_nomeUsuario', 'NomeUsuario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for dataVenda field
            //
            $column = new DateTimeViewColumn('dataVenda', 'dataVenda', 'Data Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for valorTotalVenda field
            //
            $column = new NumberViewColumn('valorTotalVenda', 'valorTotalVenda', 'Valor Total Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddExportColumn($column);
            
            //
            // View column for formaDePagamento field
            //
            $column = new TextViewColumn('formaDePagamento', 'formaDePagamento', 'Forma De Pagamento', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for nomeUsuario field
            //
            $column = new TextViewColumn('idUsuario', 'idUsuario_nomeUsuario', 'NomeUsuario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for dataVenda field
            //
            $column = new DateTimeViewColumn('dataVenda', 'dataVenda', 'Data Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for valorTotalVenda field
            //
            $column = new NumberViewColumn('valorTotalVenda', 'valorTotalVenda', 'Valor Total Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(4);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('.');
            $grid->AddCompareColumn($column);
            
            //
            // View column for formaDePagamento field
            //
            $column = new TextViewColumn('formaDePagamento', 'formaDePagamento', 'Forma De Pagamento', $this->dataset);
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
            $detailPage = new ADG2L_Vendas_ADG2L_FluxoCaixaPage('ADG2L_Vendas_ADG2L_FluxoCaixa', $this, array('idVenda'), array('idVenda'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('ADG2L_Vendas.ADG2L_FluxoCaixa'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('ADG2L_Vendas.ADG2L_FluxoCaixa'));
            $detailPage->SetHttpHandlerName('ADG2L_Vendas_ADG2L_FluxoCaixa_handler');
            $handler = new PageHTTPHandler('ADG2L_Vendas_ADG2L_FluxoCaixa_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $detailPage = new ADG2L_Vendas_ADG2L_VendaProdutosPage('ADG2L_Vendas_ADG2L_VendaProdutos', $this, array('idVenda'), array('idVenda'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('ADG2L_Vendas.ADG2L_VendaProdutos'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('ADG2L_Vendas.ADG2L_VendaProdutos'));
            $detailPage->SetHttpHandlerName('ADG2L_Vendas_ADG2L_VendaProdutos_handler');
            $handler = new PageHTTPHandler('ADG2L_Vendas_ADG2L_VendaProdutos_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idUsuario', true, true, true),
                    new StringField('nomeUsuario', true),
                    new StringField('senhaUsuario', true),
                    new StringField('emailUsuario', true),
                    new StringField('cpfUsuario', true),
                    new StringField('tipoLogradouro', true),
                    new StringField('nomeLogradouro', true),
                    new StringField('numeroLogradouro', true),
                    new StringField('complementoLogradouro'),
                    new StringField('bairro', true),
                    new StringField('cidade', true),
                    new StringField('cep', true),
                    new StringField('DDI', true),
                    new StringField('DDD', true),
                    new StringField('numeroTelefone'),
                    new DateTimeField('dataNasc'),
                    new StringField('token_recuperacao')
                )
            );
            $lookupDataset->setOrderByField('nomeUsuario', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_ADG2L_Vendas_idUsuario_search', 'idUsuario', 'nomeUsuario', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idUsuario', true, true, true),
                    new StringField('nomeUsuario', true),
                    new StringField('senhaUsuario', true),
                    new StringField('emailUsuario', true),
                    new StringField('cpfUsuario', true),
                    new StringField('tipoLogradouro', true),
                    new StringField('nomeLogradouro', true),
                    new StringField('numeroLogradouro', true),
                    new StringField('complementoLogradouro'),
                    new StringField('bairro', true),
                    new StringField('cidade', true),
                    new StringField('cep', true),
                    new StringField('DDI', true),
                    new StringField('DDD', true),
                    new StringField('numeroTelefone'),
                    new DateTimeField('dataNasc'),
                    new StringField('token_recuperacao')
                )
            );
            $lookupDataset->setOrderByField('nomeUsuario', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_ADG2L_Vendas_idUsuario_search', 'idUsuario', 'nomeUsuario', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idUsuario', true, true, true),
                    new StringField('nomeUsuario', true),
                    new StringField('senhaUsuario', true),
                    new StringField('emailUsuario', true),
                    new StringField('cpfUsuario', true),
                    new StringField('tipoLogradouro', true),
                    new StringField('nomeLogradouro', true),
                    new StringField('numeroLogradouro', true),
                    new StringField('complementoLogradouro'),
                    new StringField('bairro', true),
                    new StringField('cidade', true),
                    new StringField('cep', true),
                    new StringField('DDI', true),
                    new StringField('DDD', true),
                    new StringField('numeroTelefone'),
                    new DateTimeField('dataNasc'),
                    new StringField('token_recuperacao')
                )
            );
            $lookupDataset->setOrderByField('nomeUsuario', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_ADG2L_Vendas_idUsuario_search', 'idUsuario', 'nomeUsuario', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`ADG2L_Usuarios`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('idUsuario', true, true, true),
                    new StringField('nomeUsuario', true),
                    new StringField('senhaUsuario', true),
                    new StringField('emailUsuario', true),
                    new StringField('cpfUsuario', true),
                    new StringField('tipoLogradouro', true),
                    new StringField('nomeLogradouro', true),
                    new StringField('numeroLogradouro', true),
                    new StringField('complementoLogradouro'),
                    new StringField('bairro', true),
                    new StringField('cidade', true),
                    new StringField('cep', true),
                    new StringField('DDI', true),
                    new StringField('DDD', true),
                    new StringField('numeroTelefone'),
                    new DateTimeField('dataNasc'),
                    new StringField('token_recuperacao')
                )
            );
            $lookupDataset->setOrderByField('nomeUsuario', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_ADG2L_Vendas_idUsuario_search', 'idUsuario', 'nomeUsuario', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            
            
            new ADG2L_Vendas_idUsuarioModalViewPage($this, GetCurrentUserPermissionsForPage('ADG2L_Vendas.idUsuario'));
            new ADG2L_Vendas_idUsuarioNestedPage($this, GetCurrentUserPermissionsForPage('ADG2L_Vendas.idUsuario'));
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
        $Page = new ADG2L_VendasPage("ADG2L_Vendas", "ADG2L_Vendas.php", GetCurrentUserPermissionsForPage("ADG2L_Vendas"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("ADG2L_Vendas"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
