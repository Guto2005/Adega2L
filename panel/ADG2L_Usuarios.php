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
    
    
    
    class ADG2L_Usuarios_ADG2L_VendasPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('ADG2 L Vendas');
            $this->SetMenuLabel('ADG2 L Vendas');
    
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
                new FilterColumn($this->dataset, 'idUsuario', 'idUsuario_nomeUsuario', 'Id Usuario'),
                new FilterColumn($this->dataset, 'dataVenda', 'dataVenda', 'Data Venda'),
                new FilterColumn($this->dataset, 'valorTotalVenda', 'valorTotalVenda', 'Valor Total Venda'),
                new FilterColumn($this->dataset, 'formaDePagamento', 'formaDePagamento', 'Forma De Pagamento')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['idVenda'])
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
            $main_editor = new TextEdit('idvenda_edit');
            
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
                    FilterConditionOperator::IS_BLANK => null,
                    FilterConditionOperator::IS_NOT_BLANK => null
                )
            );
            
            $main_editor = new DynamicCombobox('idusuario_edit', $this->CreateLinkBuilder());
            $main_editor->setAllowClear(true);
            $main_editor->setMinimumInputLength(0);
            $main_editor->SetAllowNullValue(false);
            $main_editor->SetHandlerName('filter_builder_ADG2L_Usuarios_ADG2L_Vendas_idUsuario_search');
            
            $multi_value_select_editor = new RemoteMultiValueSelect('idUsuario', $this->CreateLinkBuilder());
            $multi_value_select_editor->SetHandlerName('filter_builder_ADG2L_Usuarios_ADG2L_Vendas_idUsuario_search');
            
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
            
            $main_editor = new DateTimeEdit('datavenda_edit', false, 'd-m-Y H:i:s');
            
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
            $column = new TextViewColumn('idUsuario', 'idUsuario_nomeUsuario', 'Id Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
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
            // View column for idVenda field
            //
            $column = new NumberViewColumn('idVenda', 'idVenda', 'Id Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for nomeUsuario field
            //
            $column = new TextViewColumn('idUsuario', 'idUsuario_nomeUsuario', 'Id Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
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
            $editColumn = new DynamicLookupEditColumn('Id Usuario', 'idUsuario', 'idUsuario_nomeUsuario', 'edit_ADG2L_Usuarios_ADG2L_Vendas_idUsuario_search', $editor, $this->dataset, $lookupDataset, 'idUsuario', 'nomeUsuario', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for dataVenda field
            //
            $editor = new DateTimeEdit('datavenda_edit', false, 'd-m-Y H:i:s');
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
            $editColumn = new DynamicLookupEditColumn('Id Usuario', 'idUsuario', 'idUsuario_nomeUsuario', 'multi_edit_ADG2L_Usuarios_ADG2L_Vendas_idUsuario_search', $editor, $this->dataset, $lookupDataset, 'idUsuario', 'nomeUsuario', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for dataVenda field
            //
            $editor = new DateTimeEdit('datavenda_edit', false, 'd-m-Y H:i:s');
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
            // Edit column for idVenda field
            //
            $editor = new TextEdit('idvenda_edit');
            $editColumn = new CustomEditColumn('Id Venda', 'idVenda', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
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
            $editColumn = new DynamicLookupEditColumn('Id Usuario', 'idUsuario', 'idUsuario_nomeUsuario', 'insert_ADG2L_Usuarios_ADG2L_Vendas_idUsuario_search', $editor, $this->dataset, $lookupDataset, 'idUsuario', 'nomeUsuario', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for dataVenda field
            //
            $editor = new DateTimeEdit('datavenda_edit', false, 'd-m-Y H:i:s');
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
            // View column for idVenda field
            //
            $column = new NumberViewColumn('idVenda', 'idVenda', 'Id Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddPrintColumn($column);
            
            //
            // View column for nomeUsuario field
            //
            $column = new TextViewColumn('idUsuario', 'idUsuario_nomeUsuario', 'Id Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
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
            // View column for idVenda field
            //
            $column = new NumberViewColumn('idVenda', 'idVenda', 'Id Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddExportColumn($column);
            
            //
            // View column for nomeUsuario field
            //
            $column = new TextViewColumn('idUsuario', 'idUsuario_nomeUsuario', 'Id Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
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
            // View column for idVenda field
            //
            $column = new NumberViewColumn('idVenda', 'idVenda', 'Id Venda', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $grid->AddCompareColumn($column);
            
            //
            // View column for nomeUsuario field
            //
            $column = new TextViewColumn('idUsuario', 'idUsuario_nomeUsuario', 'Id Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_ADG2L_Usuarios_ADG2L_Vendas_idUsuario_search', 'idUsuario', 'nomeUsuario', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'filter_builder_ADG2L_Usuarios_ADG2L_Vendas_idUsuario_search', 'idUsuario', 'nomeUsuario', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_ADG2L_Usuarios_ADG2L_Vendas_idUsuario_search', 'idUsuario', 'nomeUsuario', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'multi_edit_ADG2L_Usuarios_ADG2L_Vendas_idUsuario_search', 'idUsuario', 'nomeUsuario', null, 20);
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
    
    
    
    class ADG2L_UsuariosPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('ADG2 L Usuarios');
            $this->SetMenuLabel('Usuarios');
    
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
                new FilterColumn($this->dataset, 'idUsuario', 'idUsuario', 'Id Usuario'),
                new FilterColumn($this->dataset, 'nomeUsuario', 'nomeUsuario', 'Nome Usuario'),
                new FilterColumn($this->dataset, 'senhaUsuario', 'senhaUsuario', 'Senha Usuario'),
                new FilterColumn($this->dataset, 'emailUsuario', 'emailUsuario', 'Email Usuario'),
                new FilterColumn($this->dataset, 'cpfUsuario', 'cpfUsuario', 'Cpf Usuario'),
                new FilterColumn($this->dataset, 'tipoLogradouro', 'tipoLogradouro', 'Tipo Logradouro'),
                new FilterColumn($this->dataset, 'nomeLogradouro', 'nomeLogradouro', 'Nome Logradouro'),
                new FilterColumn($this->dataset, 'numeroLogradouro', 'numeroLogradouro', 'Numero Logradouro'),
                new FilterColumn($this->dataset, 'complementoLogradouro', 'complementoLogradouro', 'Complemento Logradouro'),
                new FilterColumn($this->dataset, 'bairro', 'bairro', 'Bairro'),
                new FilterColumn($this->dataset, 'cidade', 'cidade', 'Cidade'),
                new FilterColumn($this->dataset, 'cep', 'cep', 'Cep'),
                new FilterColumn($this->dataset, 'DDI', 'DDI', 'DDI'),
                new FilterColumn($this->dataset, 'DDD', 'DDD', 'DDD'),
                new FilterColumn($this->dataset, 'numeroTelefone', 'numeroTelefone', 'Numero Telefone'),
                new FilterColumn($this->dataset, 'dataNasc', 'dataNasc', 'Data Nasc'),
                new FilterColumn($this->dataset, 'token_recuperacao', 'token_recuperacao', 'Token Recuperacao')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['nomeUsuario'])
                ->addColumn($columns['senhaUsuario'])
                ->addColumn($columns['emailUsuario'])
                ->addColumn($columns['cpfUsuario'])
                ->addColumn($columns['tipoLogradouro'])
                ->addColumn($columns['nomeLogradouro'])
                ->addColumn($columns['numeroLogradouro'])
                ->addColumn($columns['complementoLogradouro'])
                ->addColumn($columns['bairro'])
                ->addColumn($columns['cidade'])
                ->addColumn($columns['cep'])
                ->addColumn($columns['DDI'])
                ->addColumn($columns['DDD'])
                ->addColumn($columns['numeroTelefone'])
                ->addColumn($columns['dataNasc'])
                ->addColumn($columns['token_recuperacao']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('dataNasc');
        }
    
        protected function setupFilterBuilder(FilterBuilder $filterBuilder, FixedKeysArray $columns)
        {
            $main_editor = new TextEdit('nomeusuario_edit');
            $main_editor->SetMaxLength(80);
            
            $filterBuilder->addColumn(
                $columns['nomeUsuario'],
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
            
            $main_editor = new TextEdit('senhaUsuario');
            
            $filterBuilder->addColumn(
                $columns['senhaUsuario'],
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
            
            $main_editor = new TextEdit('emailusuario_edit');
            $main_editor->SetMaxLength(60);
            
            $filterBuilder->addColumn(
                $columns['emailUsuario'],
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
            
            $main_editor = new TextEdit('cpfusuario_edit');
            $main_editor->SetMaxLength(11);
            
            $filterBuilder->addColumn(
                $columns['cpfUsuario'],
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
            
            $main_editor = new TextEdit('tipologradouro_edit');
            $main_editor->SetMaxLength(45);
            
            $filterBuilder->addColumn(
                $columns['tipoLogradouro'],
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
            
            $main_editor = new TextEdit('nomelogradouro_edit');
            $main_editor->SetMaxLength(100);
            
            $filterBuilder->addColumn(
                $columns['nomeLogradouro'],
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
            
            $main_editor = new TextEdit('numerologradouro_edit');
            $main_editor->SetMaxLength(6);
            
            $filterBuilder->addColumn(
                $columns['numeroLogradouro'],
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
            
            $main_editor = new TextEdit('complementoLogradouro');
            
            $filterBuilder->addColumn(
                $columns['complementoLogradouro'],
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
            
            $main_editor = new TextEdit('bairro_edit');
            $main_editor->SetMaxLength(30);
            
            $filterBuilder->addColumn(
                $columns['bairro'],
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
            
            $main_editor = new TextEdit('cidade_edit');
            $main_editor->SetMaxLength(50);
            
            $filterBuilder->addColumn(
                $columns['cidade'],
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
            
            $main_editor = new TextEdit('cep_edit');
            $main_editor->SetMaxLength(8);
            
            $filterBuilder->addColumn(
                $columns['cep'],
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
            
            $main_editor = new TextEdit('ddi_edit');
            $main_editor->SetMaxLength(3);
            
            $filterBuilder->addColumn(
                $columns['DDI'],
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
            
            $main_editor = new TextEdit('ddd_edit');
            $main_editor->SetMaxLength(3);
            
            $filterBuilder->addColumn(
                $columns['DDD'],
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
            
            $main_editor = new TextEdit('numerotelefone_edit');
            $main_editor->SetMaxLength(9);
            
            $filterBuilder->addColumn(
                $columns['numeroTelefone'],
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
            
            $main_editor = new DateTimeEdit('datanasc_edit', false, 'd-m-Y H:i:s');
            
            $filterBuilder->addColumn(
                $columns['dataNasc'],
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
            
            $main_editor = new TextEdit('token_recuperacao');
            
            $filterBuilder->addColumn(
                $columns['token_recuperacao'],
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
            if (GetCurrentUserPermissionsForPage('ADG2L_Usuarios.ADG2L_Vendas')->HasViewGrant() && $withDetails)
            {
            //
            // View column for ADG2L_Usuarios_ADG2L_Vendas detail
            //
            $column = new DetailColumn(array('idUsuario'), 'ADG2L_Usuarios.ADG2L_Vendas', 'ADG2L_Usuarios_ADG2L_Vendas_handler', $this->dataset, 'ADG2 L Vendas');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for idUsuario field
            //
            $column = new NumberViewColumn('idUsuario', 'idUsuario', 'Id Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator(',');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for nomeUsuario field
            //
            $column = new TextViewColumn('nomeUsuario', 'nomeUsuario', 'Nome Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for senhaUsuario field
            //
            $column = new TextViewColumn('senhaUsuario', 'senhaUsuario', 'Senha Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for emailUsuario field
            //
            $column = new TextViewColumn('emailUsuario', 'emailUsuario', 'Email Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for cpfUsuario field
            //
            $column = new TextViewColumn('cpfUsuario', 'cpfUsuario', 'Cpf Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for tipoLogradouro field
            //
            $column = new TextViewColumn('tipoLogradouro', 'tipoLogradouro', 'Tipo Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for nomeLogradouro field
            //
            $column = new TextViewColumn('nomeLogradouro', 'nomeLogradouro', 'Nome Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for numeroLogradouro field
            //
            $column = new TextViewColumn('numeroLogradouro', 'numeroLogradouro', 'Numero Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for complementoLogradouro field
            //
            $column = new TextViewColumn('complementoLogradouro', 'complementoLogradouro', 'Complemento Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for bairro field
            //
            $column = new TextViewColumn('bairro', 'bairro', 'Bairro', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for cidade field
            //
            $column = new TextViewColumn('cidade', 'cidade', 'Cidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for cep field
            //
            $column = new TextViewColumn('cep', 'cep', 'Cep', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for DDI field
            //
            $column = new TextViewColumn('DDI', 'DDI', 'DDI', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for DDD field
            //
            $column = new TextViewColumn('DDD', 'DDD', 'DDD', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for numeroTelefone field
            //
            $column = new TextViewColumn('numeroTelefone', 'numeroTelefone', 'Numero Telefone', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for dataNasc field
            //
            $column = new DateTimeViewColumn('dataNasc', 'dataNasc', 'Data Nasc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for token_recuperacao field
            //
            $column = new TextViewColumn('token_recuperacao', 'token_recuperacao', 'Token Recuperacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
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
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for idUsuario field
            //
            $editor = new TextEdit('idusuario_edit');
            $editColumn = new CustomEditColumn('Id Usuario', 'idUsuario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nomeUsuario field
            //
            $editor = new TextEdit('nomeusuario_edit');
            $editor->SetMaxLength(80);
            $editColumn = new CustomEditColumn('Nome Usuario', 'nomeUsuario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for senhaUsuario field
            //
            $editor = new TextAreaEdit('senhausuario_edit', 50, 8);
            $editColumn = new CustomEditColumn('Senha Usuario', 'senhaUsuario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for emailUsuario field
            //
            $editor = new TextEdit('emailusuario_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Email Usuario', 'emailUsuario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cpfUsuario field
            //
            $editor = new TextEdit('cpfusuario_edit');
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('Cpf Usuario', 'cpfUsuario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for tipoLogradouro field
            //
            $editor = new TextEdit('tipologradouro_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Tipo Logradouro', 'tipoLogradouro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for nomeLogradouro field
            //
            $editor = new TextEdit('nomelogradouro_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Nome Logradouro', 'nomeLogradouro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for numeroLogradouro field
            //
            $editor = new TextEdit('numerologradouro_edit');
            $editor->SetMaxLength(6);
            $editColumn = new CustomEditColumn('Numero Logradouro', 'numeroLogradouro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for complementoLogradouro field
            //
            $editor = new TextAreaEdit('complementologradouro_edit', 50, 8);
            $editColumn = new CustomEditColumn('Complemento Logradouro', 'complementoLogradouro', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for bairro field
            //
            $editor = new TextEdit('bairro_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Bairro', 'bairro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cidade field
            //
            $editor = new TextEdit('cidade_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Cidade', 'cidade', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for cep field
            //
            $editor = new TextEdit('cep_edit');
            $editor->SetMaxLength(8);
            $editColumn = new CustomEditColumn('Cep', 'cep', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for DDI field
            //
            $editor = new TextEdit('ddi_edit');
            $editor->SetMaxLength(3);
            $editColumn = new CustomEditColumn('DDI', 'DDI', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for DDD field
            //
            $editor = new TextEdit('ddd_edit');
            $editor->SetMaxLength(3);
            $editColumn = new CustomEditColumn('DDD', 'DDD', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for numeroTelefone field
            //
            $editor = new TextEdit('numerotelefone_edit');
            $editor->SetMaxLength(9);
            $editColumn = new CustomEditColumn('Numero Telefone', 'numeroTelefone', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for dataNasc field
            //
            $editor = new DateTimeEdit('datanasc_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Data Nasc', 'dataNasc', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for token_recuperacao field
            //
            $editor = new TextAreaEdit('token_recuperacao_edit', 50, 8);
            $editColumn = new CustomEditColumn('Token Recuperacao', 'token_recuperacao', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
        }
    
        protected function AddMultiEditColumns(Grid $grid)
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
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for senhaUsuario field
            //
            $editor = new TextAreaEdit('senhausuario_edit', 50, 8);
            $editColumn = new CustomEditColumn('Senha Usuario', 'senhaUsuario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for emailUsuario field
            //
            $editor = new TextEdit('emailusuario_edit');
            $editor->SetMaxLength(60);
            $editColumn = new CustomEditColumn('Email Usuario', 'emailUsuario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cpfUsuario field
            //
            $editor = new TextEdit('cpfusuario_edit');
            $editor->SetMaxLength(11);
            $editColumn = new CustomEditColumn('Cpf Usuario', 'cpfUsuario', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for tipoLogradouro field
            //
            $editor = new TextEdit('tipologradouro_edit');
            $editor->SetMaxLength(45);
            $editColumn = new CustomEditColumn('Tipo Logradouro', 'tipoLogradouro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for nomeLogradouro field
            //
            $editor = new TextEdit('nomelogradouro_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Nome Logradouro', 'nomeLogradouro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for numeroLogradouro field
            //
            $editor = new TextEdit('numerologradouro_edit');
            $editor->SetMaxLength(6);
            $editColumn = new CustomEditColumn('Numero Logradouro', 'numeroLogradouro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for complementoLogradouro field
            //
            $editor = new TextAreaEdit('complementologradouro_edit', 50, 8);
            $editColumn = new CustomEditColumn('Complemento Logradouro', 'complementoLogradouro', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for bairro field
            //
            $editor = new TextEdit('bairro_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Bairro', 'bairro', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cidade field
            //
            $editor = new TextEdit('cidade_edit');
            $editor->SetMaxLength(50);
            $editColumn = new CustomEditColumn('Cidade', 'cidade', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for cep field
            //
            $editor = new TextEdit('cep_edit');
            $editor->SetMaxLength(8);
            $editColumn = new CustomEditColumn('Cep', 'cep', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for DDI field
            //
            $editor = new TextEdit('ddi_edit');
            $editor->SetMaxLength(3);
            $editColumn = new CustomEditColumn('DDI', 'DDI', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for DDD field
            //
            $editor = new TextEdit('ddd_edit');
            $editor->SetMaxLength(3);
            $editColumn = new CustomEditColumn('DDD', 'DDD', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for numeroTelefone field
            //
            $editor = new TextEdit('numerotelefone_edit');
            $editor->SetMaxLength(9);
            $editColumn = new CustomEditColumn('Numero Telefone', 'numeroTelefone', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for dataNasc field
            //
            $editor = new DateTimeEdit('datanasc_edit', false, 'd-m-Y H:i:s');
            $editColumn = new CustomEditColumn('Data Nasc', 'dataNasc', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddMultiEditColumn($editColumn);
            
            //
            // Edit column for token_recuperacao field
            //
            $editor = new TextAreaEdit('token_recuperacao_edit', 50, 8);
            $editColumn = new CustomEditColumn('Token Recuperacao', 'token_recuperacao', $editor, $this->dataset);
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
            $column = new TextViewColumn('nomeUsuario', 'nomeUsuario', 'Nome Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for senhaUsuario field
            //
            $column = new TextViewColumn('senhaUsuario', 'senhaUsuario', 'Senha Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for emailUsuario field
            //
            $column = new TextViewColumn('emailUsuario', 'emailUsuario', 'Email Usuario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for cpfUsuario field
            //
            $column = new TextViewColumn('cpfUsuario', 'cpfUsuario', 'Cpf Usuario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for tipoLogradouro field
            //
            $column = new TextViewColumn('tipoLogradouro', 'tipoLogradouro', 'Tipo Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for nomeLogradouro field
            //
            $column = new TextViewColumn('nomeLogradouro', 'nomeLogradouro', 'Nome Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for numeroLogradouro field
            //
            $column = new TextViewColumn('numeroLogradouro', 'numeroLogradouro', 'Numero Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for complementoLogradouro field
            //
            $column = new TextViewColumn('complementoLogradouro', 'complementoLogradouro', 'Complemento Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for bairro field
            //
            $column = new TextViewColumn('bairro', 'bairro', 'Bairro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for cidade field
            //
            $column = new TextViewColumn('cidade', 'cidade', 'Cidade', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for cep field
            //
            $column = new TextViewColumn('cep', 'cep', 'Cep', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for DDI field
            //
            $column = new TextViewColumn('DDI', 'DDI', 'DDI', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for DDD field
            //
            $column = new TextViewColumn('DDD', 'DDD', 'DDD', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for numeroTelefone field
            //
            $column = new TextViewColumn('numeroTelefone', 'numeroTelefone', 'Numero Telefone', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for dataNasc field
            //
            $column = new DateTimeViewColumn('dataNasc', 'dataNasc', 'Data Nasc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for token_recuperacao field
            //
            $column = new TextViewColumn('token_recuperacao', 'token_recuperacao', 'Token Recuperacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for nomeUsuario field
            //
            $column = new TextViewColumn('nomeUsuario', 'nomeUsuario', 'Nome Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for senhaUsuario field
            //
            $column = new TextViewColumn('senhaUsuario', 'senhaUsuario', 'Senha Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for emailUsuario field
            //
            $column = new TextViewColumn('emailUsuario', 'emailUsuario', 'Email Usuario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for cpfUsuario field
            //
            $column = new TextViewColumn('cpfUsuario', 'cpfUsuario', 'Cpf Usuario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for tipoLogradouro field
            //
            $column = new TextViewColumn('tipoLogradouro', 'tipoLogradouro', 'Tipo Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for nomeLogradouro field
            //
            $column = new TextViewColumn('nomeLogradouro', 'nomeLogradouro', 'Nome Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for numeroLogradouro field
            //
            $column = new TextViewColumn('numeroLogradouro', 'numeroLogradouro', 'Numero Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for complementoLogradouro field
            //
            $column = new TextViewColumn('complementoLogradouro', 'complementoLogradouro', 'Complemento Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for bairro field
            //
            $column = new TextViewColumn('bairro', 'bairro', 'Bairro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for cidade field
            //
            $column = new TextViewColumn('cidade', 'cidade', 'Cidade', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for cep field
            //
            $column = new TextViewColumn('cep', 'cep', 'Cep', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for DDI field
            //
            $column = new TextViewColumn('DDI', 'DDI', 'DDI', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for DDD field
            //
            $column = new TextViewColumn('DDD', 'DDD', 'DDD', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for numeroTelefone field
            //
            $column = new TextViewColumn('numeroTelefone', 'numeroTelefone', 'Numero Telefone', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for dataNasc field
            //
            $column = new DateTimeViewColumn('dataNasc', 'dataNasc', 'Data Nasc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for token_recuperacao field
            //
            $column = new TextViewColumn('token_recuperacao', 'token_recuperacao', 'Token Recuperacao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
        }
    
        private function AddCompareColumns(Grid $grid)
        {
            //
            // View column for nomeUsuario field
            //
            $column = new TextViewColumn('nomeUsuario', 'nomeUsuario', 'Nome Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for senhaUsuario field
            //
            $column = new TextViewColumn('senhaUsuario', 'senhaUsuario', 'Senha Usuario', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for emailUsuario field
            //
            $column = new TextViewColumn('emailUsuario', 'emailUsuario', 'Email Usuario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for cpfUsuario field
            //
            $column = new TextViewColumn('cpfUsuario', 'cpfUsuario', 'Cpf Usuario', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for tipoLogradouro field
            //
            $column = new TextViewColumn('tipoLogradouro', 'tipoLogradouro', 'Tipo Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for nomeLogradouro field
            //
            $column = new TextViewColumn('nomeLogradouro', 'nomeLogradouro', 'Nome Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for numeroLogradouro field
            //
            $column = new TextViewColumn('numeroLogradouro', 'numeroLogradouro', 'Numero Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for complementoLogradouro field
            //
            $column = new TextViewColumn('complementoLogradouro', 'complementoLogradouro', 'Complemento Logradouro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddCompareColumn($column);
            
            //
            // View column for bairro field
            //
            $column = new TextViewColumn('bairro', 'bairro', 'Bairro', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for cidade field
            //
            $column = new TextViewColumn('cidade', 'cidade', 'Cidade', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for cep field
            //
            $column = new TextViewColumn('cep', 'cep', 'Cep', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for DDI field
            //
            $column = new TextViewColumn('DDI', 'DDI', 'DDI', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for DDD field
            //
            $column = new TextViewColumn('DDD', 'DDD', 'DDD', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for numeroTelefone field
            //
            $column = new TextViewColumn('numeroTelefone', 'numeroTelefone', 'Numero Telefone', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddCompareColumn($column);
            
            //
            // View column for dataNasc field
            //
            $column = new DateTimeViewColumn('dataNasc', 'dataNasc', 'Data Nasc', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('d-m-Y H:i:s');
            $grid->AddCompareColumn($column);
            
            //
            // View column for token_recuperacao field
            //
            $column = new TextViewColumn('token_recuperacao', 'token_recuperacao', 'Token Recuperacao', $this->dataset);
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
            $detailPage = new ADG2L_Usuarios_ADG2L_VendasPage('ADG2L_Usuarios_ADG2L_Vendas', $this, array('idUsuario'), array('idUsuario'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('ADG2L_Usuarios.ADG2L_Vendas'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('ADG2L_Usuarios.ADG2L_Vendas'));
            $detailPage->SetHttpHandlerName('ADG2L_Usuarios_ADG2L_Vendas_handler');
            $handler = new PageHTTPHandler('ADG2L_Usuarios_ADG2L_Vendas_handler', $detailPage);
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
        $Page = new ADG2L_UsuariosPage("ADG2L_Usuarios", "ADG2L_Usuarios.php", GetCurrentUserPermissionsForPage("ADG2L_Usuarios"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("ADG2L_Usuarios"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
