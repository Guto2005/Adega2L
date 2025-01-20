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
    
    
    
    class servicos_OSItensPage extends DetailPage
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('OSItens');
            $this->SetMenuLabel('ITENS DA OS');
    
            $selectQuery = 'select *, (item_valor * item_qtd) as item_sub from itens';
            $insertQuery = array('INSERT INTO itens (item_produto, item_valor, item_qtd, item_serv_cod)
            values 
            (:item_produto, :item_valor, :item_qtd, :item_serv_cod)');
            $updateQuery = array('UPDATE itens SET 
            item_produto= :item_produto,
            item_valor= :item_valor,
            item_qtd= :item_qtd,
            item_serv_cod= :item_serv_cod
            WHERE item_id = :item_id');
            $deleteQuery = array('DELETE from itens
            WHERE item_id = :item_id');
            $this->dataset = new QueryDataset(
              MySqlIConnectionFactory::getInstance(), 
              GetConnectionOptions(),
              $selectQuery, $insertQuery, $updateQuery, $deleteQuery, 'OSItens');
            $this->dataset->addFields(
                array(
                    new IntegerField('item_id', true, true, true),
                    new IntegerField('item_produto', true),
                    new IntegerField('item_valor', true),
                    new IntegerField('item_qtd', true),
                    new StringField('item_serv_cod', true),
                    new IntegerField('item_sub')
                )
            );
            $this->dataset->AddLookupField('item_produto', 'produtos', new IntegerField('pro_id'), new StringField('pro_nome', false, false, false, false, 'item_produto_pro_nome', 'item_produto_pro_nome_produtos'), 'item_produto_pro_nome_produtos');
            $this->dataset->AddLookupField('item_serv_cod', 'servicos', new StringField('serv_cod'), new IntegerField('serv_id', false, false, false, false, 'item_serv_cod_serv_id', 'item_serv_cod_serv_id_servicos'), 'item_serv_cod_serv_id_servicos');
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
                new FilterColumn($this->dataset, 'item_serv_cod', 'item_serv_cod_serv_id', 'Item Serv Cod'),
                new FilterColumn($this->dataset, 'item_sub', 'item_sub', 'Item Sub')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
    
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
            // View column for pro_nome field
            //
            $column = new TextViewColumn('item_produto', 'item_produto_pro_nome', 'Item Produto', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(servicos_OSItens_item_produtoModalViewPage::getHandlerName());
            $column->SetMaxLength(75);
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
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for item_sub field
            //
            $column = new NumberViewColumn('item_sub', 'item_sub', 'Item Sub', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
    
        }
    
        protected function AddEditColumns(Grid $grid)
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
            $editColumn = new DynamicLookupEditColumn('Item Produto', 'item_produto', 'item_produto_pro_nome', 'edit_servicos_OSItens_item_produto_search', $editor, $this->dataset, $lookupDataset, 'pro_id', 'pro_nome', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(servicos_OSItens_item_produtoNestedPage::getNestedInsertHandlerName())
            );
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
            $editor = new SpinEdit('item_qtd_edit');
            $editColumn = new CustomEditColumn('Item Qtd', 'item_qtd', $editor, $this->dataset);
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
            $editColumn = new DynamicLookupEditColumn('Item Produto', 'item_produto', 'item_produto_pro_nome', 'insert_servicos_OSItens_item_produto_search', $editor, $this->dataset, $lookupDataset, 'pro_id', 'pro_nome', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(servicos_OSItens_item_produtoNestedPage::getNestedInsertHandlerName())
            );
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
            $editor = new SpinEdit('item_qtd_edit');
            $editColumn = new CustomEditColumn('Item Qtd', 'item_qtd', $editor, $this->dataset);
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
    
        }
    
        protected function AddExportColumns(Grid $grid)
        {
    
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
            return '//console.log(produtos);';
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
            $result->setTableBordered(true);
            $result->setTableCondensed(false);
            $result->SetTotal('item_sub', PredefinedAggregate::$Sum);
            $result->setReloadPageAfterAjaxOperation(true);
            
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
            $grid->SetInsertClientEditorValueChangedScript('// verifico se é o combo de item que estou pegando
            if (sender.getFieldName() == \'item_produto\') {
            
            // função que vai filtrar
            function pegarValor(prod) {
                     return prod.pro_id === sender.getValue(); 
            }
               
            // pego o valor que eu preciso   
            var valor = produtos.find(pegarValor).pro_valor;
            
            //console.log(valor);
               
            //passo valor ao campo
               editors[\'item_valor\'].setValue(valor);
            }
            
            if (sender.getFieldName() == \'item_produto\') {
            
                // Função que vai filtrar o produto pelo ID
                function pegarProduto(prod) {
                    // Certifico que a comparação seja coerente
                    return String(prod.pro_id) === String(sender.getValue());
                }
            
                // Encontro o produto correspondente
                var produtoSelecionado = produtos.find(pegarProduto);
            
                if (produtoSelecionado) {
                    // Verifico se o campo `pro_estoque` existe
                    if (\'pro_estoque\' in produtoSelecionado) {
                        var estoque = produtoSelecionado.pro_estoque;
            
                        // Passo o estoque ao campo
                        editors[\'item_qtd\'].setValue(estoque);
                    } else {
                        console.warn("O campo \'pro_estoque\' não existe no produto selecionado.");
                    }
                } else {
                    console.warn("Produto não encontrado. Certifique-se de que \'sender.getValue()\' corresponde a algum \'pro_id\' em \'produtos\'.");
                }
            }');
            
            $grid->SetEditClientEditorValueChangedScript('// verifico se é o combo de item que estou pegando
            if (sender.getFieldName() == \'item_produto\') {
            
            // função que vai filtrar
            function pegarValor(prod) {
                     return prod.pro_id === sender.getValue(); 
            }
               
            // pego o valor que eu preciso   
            var valor = produtos.find(pegarValor).pro_valor;
            
            //console.log(valor);
               
            //passo valor ao campo
               editors[\'item_valor\'].setValue(valor);
            }
            
            if (sender.getFieldName() == \'item_produto\') {
            
                // Função que vai filtrar o produto pelo ID
                function pegarProduto(prod) {
                    // Certifico que a comparação seja coerente
                    return String(prod.pro_id) === String(sender.getValue());
                }
            
                // Encontro o produto correspondente
                var produtoSelecionado = produtos.find(pegarProduto);
            
                if (produtoSelecionado) {
                    // Verifico se o campo `pro_estoque` existe
                    if (\'pro_estoque\' in produtoSelecionado) {
                        var estoque = produtoSelecionado.pro_estoque;
            
                        // Passo o estoque ao campo
                        editors[\'item_qtd\'].setValue(estoque);
                    } else {
                        console.warn("O campo \'pro_estoque\' não existe no produto selecionado.");
                    }
                } else {
                    console.warn("Produto não encontrado. Certifique-se de que \'sender.getValue()\' corresponde a algum \'pro_id\' em \'produtos\'.");
                }
            }');
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
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_servicos_OSItens_item_produto_search', 'pro_id', 'pro_nome', null, 20);
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
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_servicos_OSItens_item_produto_search', 'pro_id', 'pro_nome', null, 20);
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
            $values = array();
            $sql = "select * from produtos";
            $this -> GetConnection()->ExecQueryToArray($sql, $values);
            
            $pro = json_encode($values);
            echo"<script>";
            echo"var produtos = {$pro}";
            echo"</script>";
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
    
    class servicos_OSItens_item_produtoModalViewPage extends ViewBasedPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`produtos`');
            $this->dataset->addFields(
                array(
                    new IntegerField('pro_id', true, true, true),
                    new StringField('pro_nome', true),
                    new IntegerField('pro_valor', true),
                    new StringField('pro_cod'),
                    new IntegerField('pro_estoque', true),
                    new StringField('pro_img')
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for pro_id field
            //
            $column = new NumberViewColumn('pro_id', 'pro_id', 'Pro Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for pro_nome field
            //
            $column = new TextViewColumn('pro_nome', 'pro_nome', 'Pro Nome', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for pro_valor field
            //
            $column = new NumberViewColumn('pro_valor', 'pro_valor', 'Pro Valor', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(2);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator(',');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for pro_cod field
            //
            $column = new TextViewColumn('pro_cod', 'pro_cod', 'Pro Cod', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for pro_estoque field
            //
            $column = new NumberViewColumn('pro_estoque', 'pro_estoque', 'Pro Estoque', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for pro_img field
            //
            $column = new TextViewColumn('pro_img', 'pro_img', 'Pro Img', $this->dataset);
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
    
    class servicos_OSItens_item_produtoNestedPage extends NestedFormPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`produtos`');
            $this->dataset->addFields(
                array(
                    new IntegerField('pro_id', true, true, true),
                    new StringField('pro_nome', true),
                    new IntegerField('pro_valor', true),
                    new StringField('pro_cod'),
                    new IntegerField('pro_estoque', true),
                    new StringField('pro_img')
                )
            );
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for pro_nome field
            //
            $editor = new TextEdit('pro_nome_edit');
            $editor->SetMaxLength(100);
            $editColumn = new CustomEditColumn('Pro Nome', 'pro_nome', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for pro_valor field
            //
            $editor = new TextEdit('pro_valor_edit');
            $editColumn = new CustomEditColumn('Pro Valor', 'pro_valor', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for pro_cod field
            //
            $editor = new TextEdit('pro_cod_edit');
            $editor->SetMaxLength(20);
            $editColumn = new CustomEditColumn('Pro Cod', 'pro_cod', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for pro_estoque field
            //
            $editor = new TextEdit('pro_estoque_edit');
            $editColumn = new CustomEditColumn('Pro Estoque', 'pro_estoque', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for pro_img field
            //
            $editor = new TextAreaEdit('pro_img_edit', 50, 8);
            $editColumn = new CustomEditColumn('Pro Img', 'pro_img', $editor, $this->dataset);
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
    
    class servicos_serv_clienteModalViewPage extends ViewBasedPage
    {
        protected function DoBeforeCreate()
        {
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
            $this->dataset->AddLookupField('cli_id', 'servicos', new IntegerField('serv_cliente'), new IntegerField('serv_id', false, false, false, false, 'cli_id_serv_id', 'cli_id_serv_id_servicos'), 'cli_id_serv_id_servicos');
            $this->dataset->AddLookupField('cli_bairro', 'bairros', new IntegerField('bairro_id'), new StringField('bairro_nome', false, false, false, false, 'cli_bairro_bairro_nome', 'cli_bairro_bairro_nome_bairros'), 'cli_bairro_bairro_nome_bairros');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for serv_id field
            //
            $column = new NumberViewColumn('cli_id', 'cli_id_serv_id', 'Cli Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cli_nome field
            //
            $column = new TextViewColumn('cli_nome', 'cli_nome', 'Cli Nome', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cli_telefone field
            //
            $column = new TextViewColumn('cli_telefone', 'cli_telefone', 'Cli Telefone', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cli_end field
            //
            $column = new TextViewColumn('cli_end', 'cli_end', 'Cli End', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for bairro_nome field
            //
            $column = new TextViewColumn('cli_bairro', 'cli_bairro_bairro_nome', 'Cli Bairro', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for cli_cidade field
            //
            $column = new NumberViewColumn('cli_cidade', 'cli_cidade', 'Cli Cidade', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
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
    
    class servicos_serv_equipModalViewPage extends ViewBasedPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`equipamentos`');
            $this->dataset->addFields(
                array(
                    new IntegerField('eq_id', true, true, true),
                    new StringField('eq_nome')
                )
            );
            $this->dataset->AddLookupField('eq_id', 'servicos', new IntegerField('serv_equip'), new IntegerField('serv_id', false, false, false, false, 'eq_id_serv_id', 'eq_id_serv_id_servicos'), 'eq_id_serv_id_servicos');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for serv_id field
            //
            $column = new NumberViewColumn('eq_id', 'eq_id_serv_id', 'Eq Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for eq_nome field
            //
            $column = new TextViewColumn('eq_nome', 'eq_nome', 'Eq Nome', $this->dataset);
            $column->SetOrderable(true);
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
    
    class servicos_serv_marcaModalViewPage extends ViewBasedPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`marcas`');
            $this->dataset->addFields(
                array(
                    new IntegerField('marca_id', true, true, true),
                    new StringField('marca_nome', true)
                )
            );
            $this->dataset->AddLookupField('marca_id', 'servicos', new IntegerField('serv_marca'), new IntegerField('serv_id', false, false, false, false, 'marca_id_serv_id', 'marca_id_serv_id_servicos'), 'marca_id_serv_id_servicos');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
            //
            // View column for serv_id field
            //
            $column = new NumberViewColumn('marca_id', 'marca_id_serv_id', 'Marca Id', $this->dataset);
            $column->SetOrderable(true);
            $column->setNumberAfterDecimal(0);
            $column->setThousandsSeparator('.');
            $column->setDecimalSeparator('');
            $grid->AddSingleRecordViewColumn($column);
            
            //
            // View column for marca_nome field
            //
            $column = new TextViewColumn('marca_nome', 'marca_nome', 'Marca Nome', $this->dataset);
            $column->SetOrderable(true);
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
    
    class servicos_serv_clienteNestedPage extends NestedFormPage
    {
        protected function DoBeforeCreate()
        {
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
            $this->dataset->AddLookupField('cli_id', 'servicos', new IntegerField('serv_cliente'), new IntegerField('serv_id', false, false, false, false, 'cli_id_serv_id', 'cli_id_serv_id_servicos'), 'cli_id_serv_id_servicos');
            $this->dataset->AddLookupField('cli_bairro', 'bairros', new IntegerField('bairro_id'), new StringField('bairro_nome', false, false, false, false, 'cli_bairro_bairro_nome', 'cli_bairro_bairro_nome_bairros'), 'cli_bairro_bairro_nome_bairros');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for cli_nome field
            //
            $editor = new TextEdit('cli_nome_edit');
            $editor->SetMaxLength(80);
            $editColumn = new CustomEditColumn('Cli Nome', 'cli_nome', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cli_telefone field
            //
            $editor = new TextEdit('cli_telefone_edit');
            $editor->SetMaxLength(15);
            $editColumn = new CustomEditColumn('Cli Telefone', 'cli_telefone', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cli_end field
            //
            $editor = new TextEdit('cli_end_edit');
            $editor->SetMaxLength(80);
            $editColumn = new CustomEditColumn('Cli End', 'cli_end', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cli_bairro field
            //
            $editor = new DynamicCombobox('cli_bairro_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bairros`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('bairro_id', true, true, true),
                    new StringField('bairro_nome'),
                    new IntegerField('bairro_cidade', true)
                )
            );
            $lookupDataset->setOrderByField('bairro_nome', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Cli Bairro', 'cli_bairro', 'cli_bairro_bairro_nome', 'insert_servicos_serv_clienteNestedPage_cli_bairro_search', $editor, $this->dataset, $lookupDataset, 'bairro_id', 'bairro_nome', '');
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for cli_cidade field
            //
            $editor = new TextEdit('cli_cidade_edit');
            $editColumn = new CustomEditColumn('Cli Cidade', 'cli_cidade', $editor, $this->dataset);
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
    
    class servicos_serv_equipNestedPage extends NestedFormPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`equipamentos`');
            $this->dataset->addFields(
                array(
                    new IntegerField('eq_id', true, true, true),
                    new StringField('eq_nome')
                )
            );
            $this->dataset->AddLookupField('eq_id', 'servicos', new IntegerField('serv_equip'), new IntegerField('serv_id', false, false, false, false, 'eq_id_serv_id', 'eq_id_serv_id_servicos'), 'eq_id_serv_id_servicos');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for eq_nome field
            //
            $editor = new TextEdit('eq_nome_edit');
            $editor->SetMaxLength(40);
            $editColumn = new CustomEditColumn('Eq Nome', 'eq_nome', $editor, $this->dataset);
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
    
    class servicos_serv_marcaNestedPage extends NestedFormPage
    {
        protected function DoBeforeCreate()
        {
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`marcas`');
            $this->dataset->addFields(
                array(
                    new IntegerField('marca_id', true, true, true),
                    new StringField('marca_nome', true)
                )
            );
            $this->dataset->AddLookupField('marca_id', 'servicos', new IntegerField('serv_marca'), new IntegerField('serv_id', false, false, false, false, 'marca_id_serv_id', 'marca_id_serv_id_servicos'), 'marca_id_serv_id_servicos');
        }
    
        protected function DoPrepare() {
    
        }
    
        protected function AddInsertColumns(Grid $grid)
        {
            //
            // Edit column for marca_nome field
            //
            $editor = new TextEdit('marca_nome_edit');
            $editor->SetMaxLength(40);
            $editColumn = new CustomEditColumn('Marca Nome', 'marca_nome', $editor, $this->dataset);
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
    
    
    
    class servicosPage extends Page
    {
        protected function DoBeforeCreate()
        {
            $this->SetTitle('Servicos');
            $this->SetMenuLabel('Servicos');
    
            $this->dataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`servicos`');
            $this->dataset->addFields(
                array(
                    new IntegerField('serv_id', true, true, true),
                    new DateField('serv_data', true),
                    new TimeField('serv_hora', true),
                    new IntegerField('serv_cliente', true),
                    new IntegerField('serv_equip', true),
                    new IntegerField('serv_marca', true),
                    new StringField('serv_modelo'),
                    new StringField('serv_desc'),
                    new StringField('serv_laudo'),
                    new StringField('serv_cod', true),
                    new StringField('serv_fechada'),
                    new StringField('serv_exito'),
                    new DateField('serv_data_fecha'),
                    new StringField('serv_obs')
                )
            );
            $this->dataset->AddLookupField('serv_cliente', 'clientes', new IntegerField('cli_id'), new StringField('cli_nome', false, false, false, false, 'serv_cliente_cli_nome', 'serv_cliente_cli_nome_clientes'), 'serv_cliente_cli_nome_clientes');
            $this->dataset->AddLookupField('serv_equip', 'equipamentos', new IntegerField('eq_id'), new StringField('eq_nome', false, false, false, false, 'serv_equip_eq_nome', 'serv_equip_eq_nome_equipamentos'), 'serv_equip_eq_nome_equipamentos');
            $this->dataset->AddLookupField('serv_marca', 'marcas', new IntegerField('marca_id'), new StringField('marca_nome', false, false, false, false, 'serv_marca_marca_nome', 'serv_marca_marca_nome_marcas'), 'serv_marca_marca_nome_marcas');
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
                new FilterColumn($this->dataset, 'serv_id', 'serv_id', 'Serv Id'),
                new FilterColumn($this->dataset, 'serv_data', 'serv_data', 'Data'),
                new FilterColumn($this->dataset, 'serv_hora', 'serv_hora', 'Hora'),
                new FilterColumn($this->dataset, 'serv_cliente', 'serv_cliente_cli_nome', 'Clientes'),
                new FilterColumn($this->dataset, 'serv_equip', 'serv_equip_eq_nome', 'Equipamentos'),
                new FilterColumn($this->dataset, 'serv_marca', 'serv_marca_marca_nome', 'Marcas'),
                new FilterColumn($this->dataset, 'serv_modelo', 'serv_modelo', 'Modelo'),
                new FilterColumn($this->dataset, 'serv_desc', 'serv_desc', 'Descricao'),
                new FilterColumn($this->dataset, 'serv_laudo', 'serv_laudo', 'Laudo'),
                new FilterColumn($this->dataset, 'serv_cod', 'serv_cod', 'Codigo'),
                new FilterColumn($this->dataset, 'serv_fechada', 'serv_fechada', 'Fechada'),
                new FilterColumn($this->dataset, 'serv_exito', 'serv_exito', 'Exito'),
                new FilterColumn($this->dataset, 'serv_data_fecha', 'serv_data_fecha', 'Data Fecha'),
                new FilterColumn($this->dataset, 'serv_obs', 'serv_obs', 'Obs')
            );
        }
    
        protected function setupQuickFilter(QuickFilter $quickFilter, FixedKeysArray $columns)
        {
            $quickFilter
                ->addColumn($columns['serv_data'])
                ->addColumn($columns['serv_hora'])
                ->addColumn($columns['serv_cliente'])
                ->addColumn($columns['serv_equip'])
                ->addColumn($columns['serv_marca'])
                ->addColumn($columns['serv_modelo'])
                ->addColumn($columns['serv_desc'])
                ->addColumn($columns['serv_laudo'])
                ->addColumn($columns['serv_fechada'])
                ->addColumn($columns['serv_exito'])
                ->addColumn($columns['serv_data_fecha'])
                ->addColumn($columns['serv_obs']);
        }
    
        protected function setupColumnFilter(ColumnFilter $columnFilter)
        {
            $columnFilter
                ->setOptionsFor('serv_data')
                ->setOptionsFor('serv_cliente')
                ->setOptionsFor('serv_equip')
                ->setOptionsFor('serv_marca')
                ->setOptionsFor('serv_data_fecha');
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
            if (GetCurrentUserPermissionsForPage('servicos.OSItens')->HasViewGrant() && $withDetails)
            {
            //
            // View column for servicos_OSItens detail
            //
            $column = new DetailColumn(array('serv_cod'), 'servicos.OSItens', 'servicos_OSItens_handler', $this->dataset, 'ITENS DA OS');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            }
            
            //
            // View column for serv_data field
            //
            $column = new DateTimeViewColumn('serv_data', 'serv_data', 'Data', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for cli_nome field
            //
            $column = new TextViewColumn('serv_cliente', 'serv_cliente_cli_nome', 'Clientes', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(servicos_serv_clienteModalViewPage::getHandlerName());
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for eq_nome field
            //
            $column = new TextViewColumn('serv_equip', 'serv_equip_eq_nome', 'Equipamentos', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(servicos_serv_equipModalViewPage::getHandlerName());
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for marca_nome field
            //
            $column = new TextViewColumn('serv_marca', 'serv_marca_marca_nome', 'Marcas', $this->dataset);
            $column->SetOrderable(true);
            $column->setLookupRecordModalViewHandlerName(servicos_serv_marcaModalViewPage::getHandlerName());
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for serv_fechada field
            //
            $column = new TextViewColumn('serv_fechada', 'serv_fechada', 'Fechada', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for serv_exito field
            //
            $column = new TextViewColumn('serv_exito', 'serv_exito', 'Exito', $this->dataset);
            $column->SetOrderable(true);
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
            //
            // View column for serv_data_fecha field
            //
            $column = new DateTimeViewColumn('serv_data_fecha', 'serv_data_fecha', 'Data Fecha', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $column->setMinimalVisibility(ColumnVisibility::PHONE);
            $grid->AddViewColumn($column);
        }
    
        protected function AddSingleRecordViewColumns(Grid $grid)
        {
    
        }
    
        protected function AddEditColumns(Grid $grid)
        {
            //
            // Edit column for serv_data field
            //
            $editor = new DateTimeEdit('serv_data_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Data', 'serv_data', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for serv_hora field
            //
            $editor = new TimeEdit('serv_hora_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('Hora', 'serv_hora', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for serv_cliente field
            //
            $editor = new DynamicCombobox('serv_cliente_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`clientes`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('cli_id', true, true, true),
                    new StringField('cli_nome'),
                    new StringField('cli_telefone'),
                    new StringField('cli_end'),
                    new IntegerField('cli_bairro', true),
                    new IntegerField('cli_cidade', true)
                )
            );
            $lookupDataset->setOrderByField('cli_nome', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Clientes', 'serv_cliente', 'serv_cliente_cli_nome', 'edit_servicos_serv_cliente_search', $editor, $this->dataset, $lookupDataset, 'cli_id', 'cli_nome', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(servicos_serv_clienteNestedPage::getNestedInsertHandlerName())
            );
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for serv_equip field
            //
            $editor = new DynamicCombobox('serv_equip_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`equipamentos`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('eq_id', true, true, true),
                    new StringField('eq_nome')
                )
            );
            $lookupDataset->setOrderByField('eq_nome', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Equipamentos', 'serv_equip', 'serv_equip_eq_nome', '_servicos_serv_equip_search', $editor, $this->dataset, $lookupDataset, 'eq_id', 'eq_nome', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(servicos_serv_equipNestedPage::getNestedInsertHandlerName())
            );
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for serv_marca field
            //
            $editor = new DynamicCombobox('serv_marca_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`marcas`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('marca_id', true, true, true),
                    new StringField('marca_nome', true)
                )
            );
            $lookupDataset->setOrderByField('marca_nome', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Marcas', 'serv_marca', 'serv_marca_marca_nome', '_servicos_serv_marca_search', $editor, $this->dataset, $lookupDataset, 'marca_id', 'marca_nome', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(servicos_serv_marcaNestedPage::getNestedInsertHandlerName())
            );
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for serv_modelo field
            //
            $editor = new TextEdit('serv_modelo_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Modelo', 'serv_modelo', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for serv_desc field
            //
            $editor = new TextAreaEdit('serv_desc_edit', 50, 8);
            $editColumn = new CustomEditColumn('Descricao', 'serv_desc', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for serv_laudo field
            //
            $editor = new TextAreaEdit('serv_laudo_edit', 50, 8);
            $editColumn = new CustomEditColumn('Laudo', 'serv_laudo', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for serv_fechada field
            //
            $editor = new ComboBox('serv_fechada_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('S', 'S');
            $editor->addChoice('N', 'N');
            $editColumn = new CustomEditColumn('Fechada', 'serv_fechada', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for serv_exito field
            //
            $editor = new ComboBox('serv_exito_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('S', 'S');
            $editor->addChoice('N', 'N');
            $editColumn = new CustomEditColumn('Exito', 'serv_exito', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for serv_data_fecha field
            //
            $editor = new DateTimeEdit('serv_data_fecha_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Data Fecha', 'serv_data_fecha', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddEditColumn($editColumn);
            
            //
            // Edit column for serv_obs field
            //
            $editor = new TextAreaEdit('serv_obs_edit', 50, 8);
            $editColumn = new CustomEditColumn('Obs', 'serv_obs', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
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
            // Edit column for serv_data field
            //
            $editor = new DateTimeEdit('serv_data_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Data', 'serv_data', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for serv_hora field
            //
            $editor = new TimeEdit('serv_hora_edit', 'H:i:s');
            $editColumn = new CustomEditColumn('Hora', 'serv_hora', $editor, $this->dataset);
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for serv_cliente field
            //
            $editor = new DynamicCombobox('serv_cliente_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`clientes`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('cli_id', true, true, true),
                    new StringField('cli_nome'),
                    new StringField('cli_telefone'),
                    new StringField('cli_end'),
                    new IntegerField('cli_bairro', true),
                    new IntegerField('cli_cidade', true)
                )
            );
            $lookupDataset->setOrderByField('cli_nome', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Clientes', 'serv_cliente', 'serv_cliente_cli_nome', 'insert_servicos_serv_cliente_search', $editor, $this->dataset, $lookupDataset, 'cli_id', 'cli_nome', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(servicos_serv_clienteNestedPage::getNestedInsertHandlerName())
            );
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for serv_equip field
            //
            $editor = new DynamicCombobox('serv_equip_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`equipamentos`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('eq_id', true, true, true),
                    new StringField('eq_nome')
                )
            );
            $lookupDataset->setOrderByField('eq_nome', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Equipamentos', 'serv_equip', 'serv_equip_eq_nome', 'insert_servicos_serv_equip_search', $editor, $this->dataset, $lookupDataset, 'eq_id', 'eq_nome', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(servicos_serv_equipNestedPage::getNestedInsertHandlerName())
            );
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for serv_marca field
            //
            $editor = new DynamicCombobox('serv_marca_edit', $this->CreateLinkBuilder());
            $editor->setAllowClear(true);
            $editor->setMinimumInputLength(0);
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`marcas`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('marca_id', true, true, true),
                    new StringField('marca_nome', true)
                )
            );
            $lookupDataset->setOrderByField('marca_nome', 'ASC');
            $editColumn = new DynamicLookupEditColumn('Marcas', 'serv_marca', 'serv_marca_marca_nome', 'insert_servicos_serv_marca_search', $editor, $this->dataset, $lookupDataset, 'marca_id', 'marca_nome', '');
            $editColumn->setNestedInsertFormLink(
                $this->GetHandlerLink(servicos_serv_marcaNestedPage::getNestedInsertHandlerName())
            );
            $validator = new RequiredValidator(StringUtils::Format($this->GetLocalizerCaptions()->GetMessageString('RequiredValidationMessage'), $editColumn->GetCaption()));
            $editor->GetValidatorCollection()->AddValidator($validator);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for serv_modelo field
            //
            $editor = new TextEdit('serv_modelo_edit');
            $editor->SetMaxLength(30);
            $editColumn = new CustomEditColumn('Modelo', 'serv_modelo', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for serv_desc field
            //
            $editor = new TextAreaEdit('serv_desc_edit', 50, 8);
            $editColumn = new CustomEditColumn('Descricao', 'serv_desc', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for serv_laudo field
            //
            $editor = new TextAreaEdit('serv_laudo_edit', 50, 8);
            $editColumn = new CustomEditColumn('Laudo', 'serv_laudo', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for serv_fechada field
            //
            $editor = new ComboBox('serv_fechada_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('S', 'S');
            $editor->addChoice('N', 'N');
            $editColumn = new CustomEditColumn('Fechada', 'serv_fechada', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for serv_exito field
            //
            $editor = new ComboBox('serv_exito_edit', $this->GetLocalizerCaptions()->GetMessageString('PleaseSelect'));
            $editor->addChoice('S', 'S');
            $editor->addChoice('N', 'N');
            $editColumn = new CustomEditColumn('Exito', 'serv_exito', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for serv_data_fecha field
            //
            $editor = new DateTimeEdit('serv_data_fecha_edit', false, 'Y-m-d');
            $editColumn = new CustomEditColumn('Data Fecha', 'serv_data_fecha', $editor, $this->dataset);
            $editColumn->SetAllowSetToNull(true);
            $this->ApplyCommonColumnEditProperties($editColumn);
            $grid->AddInsertColumn($editColumn);
            
            //
            // Edit column for serv_obs field
            //
            $editor = new TextAreaEdit('serv_obs_edit', 50, 8);
            $editColumn = new CustomEditColumn('Obs', 'serv_obs', $editor, $this->dataset);
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
            // View column for serv_data field
            //
            $column = new DateTimeViewColumn('serv_data', 'serv_data', 'Data', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for serv_hora field
            //
            $column = new DateTimeViewColumn('serv_hora', 'serv_hora', 'Hora', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddPrintColumn($column);
            
            //
            // View column for cli_nome field
            //
            $column = new TextViewColumn('serv_cliente', 'serv_cliente_cli_nome', 'Clientes', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for eq_nome field
            //
            $column = new TextViewColumn('serv_equip', 'serv_equip_eq_nome', 'Equipamentos', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for marca_nome field
            //
            $column = new TextViewColumn('serv_marca', 'serv_marca_marca_nome', 'Marcas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for serv_modelo field
            //
            $column = new TextViewColumn('serv_modelo', 'serv_modelo', 'Modelo', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for serv_desc field
            //
            $column = new TextViewColumn('serv_desc', 'serv_desc', 'Descricao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for serv_laudo field
            //
            $column = new TextViewColumn('serv_laudo', 'serv_laudo', 'Laudo', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
            
            //
            // View column for serv_fechada field
            //
            $column = new TextViewColumn('serv_fechada', 'serv_fechada', 'Fechada', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for serv_exito field
            //
            $column = new TextViewColumn('serv_exito', 'serv_exito', 'Exito', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddPrintColumn($column);
            
            //
            // View column for serv_data_fecha field
            //
            $column = new DateTimeViewColumn('serv_data_fecha', 'serv_data_fecha', 'Data Fecha', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddPrintColumn($column);
            
            //
            // View column for serv_obs field
            //
            $column = new TextViewColumn('serv_obs', 'serv_obs', 'Obs', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddPrintColumn($column);
        }
    
        protected function AddExportColumns(Grid $grid)
        {
            //
            // View column for serv_data field
            //
            $column = new DateTimeViewColumn('serv_data', 'serv_data', 'Data', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for serv_hora field
            //
            $column = new DateTimeViewColumn('serv_hora', 'serv_hora', 'Hora', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('H:i:s');
            $grid->AddExportColumn($column);
            
            //
            // View column for cli_nome field
            //
            $column = new TextViewColumn('serv_cliente', 'serv_cliente_cli_nome', 'Clientes', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for eq_nome field
            //
            $column = new TextViewColumn('serv_equip', 'serv_equip_eq_nome', 'Equipamentos', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for marca_nome field
            //
            $column = new TextViewColumn('serv_marca', 'serv_marca_marca_nome', 'Marcas', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for serv_modelo field
            //
            $column = new TextViewColumn('serv_modelo', 'serv_modelo', 'Modelo', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for serv_desc field
            //
            $column = new TextViewColumn('serv_desc', 'serv_desc', 'Descricao', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for serv_laudo field
            //
            $column = new TextViewColumn('serv_laudo', 'serv_laudo', 'Laudo', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
            $grid->AddExportColumn($column);
            
            //
            // View column for serv_fechada field
            //
            $column = new TextViewColumn('serv_fechada', 'serv_fechada', 'Fechada', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for serv_exito field
            //
            $column = new TextViewColumn('serv_exito', 'serv_exito', 'Exito', $this->dataset);
            $column->SetOrderable(true);
            $grid->AddExportColumn($column);
            
            //
            // View column for serv_data_fecha field
            //
            $column = new DateTimeViewColumn('serv_data_fecha', 'serv_data_fecha', 'Data Fecha', $this->dataset);
            $column->SetOrderable(true);
            $column->SetDateTimeFormat('Y-m-d');
            $grid->AddExportColumn($column);
            
            //
            // View column for serv_obs field
            //
            $column = new TextViewColumn('serv_obs', 'serv_obs', 'Obs', $this->dataset);
            $column->SetOrderable(true);
            $column->SetMaxLength(75);
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
            $result->setTableBordered(false);
            $result->setTableCondensed(false);
            
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
            $this->setPrintListRecordAvailable(true);
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
            $detailPage = new servicos_OSItensPage('servicos_OSItens', $this, array('item_serv_cod'), array('serv_cod'), $this->GetForeignKeyFields(), $this->CreateMasterDetailRecordGrid(), $this->dataset, GetCurrentUserPermissionsForPage('servicos.OSItens'), 'UTF-8');
            $detailPage->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource('servicos.OSItens'));
            $detailPage->SetHttpHandlerName('servicos_OSItens_handler');
            $handler = new PageHTTPHandler('servicos_OSItens_handler', $detailPage);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`clientes`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('cli_id', true, true, true),
                    new StringField('cli_nome'),
                    new StringField('cli_telefone'),
                    new StringField('cli_end'),
                    new IntegerField('cli_bairro', true),
                    new IntegerField('cli_cidade', true)
                )
            );
            $lookupDataset->setOrderByField('cli_nome', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_servicos_serv_cliente_search', 'cli_id', 'cli_nome', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`equipamentos`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('eq_id', true, true, true),
                    new StringField('eq_nome')
                )
            );
            $lookupDataset->setOrderByField('eq_nome', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_servicos_serv_equip_search', 'eq_id', 'eq_nome', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`marcas`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('marca_id', true, true, true),
                    new StringField('marca_nome', true)
                )
            );
            $lookupDataset->setOrderByField('marca_nome', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_servicos_serv_marca_search', 'marca_id', 'marca_nome', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`clientes`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('cli_id', true, true, true),
                    new StringField('cli_nome'),
                    new StringField('cli_telefone'),
                    new StringField('cli_end'),
                    new IntegerField('cli_bairro', true),
                    new IntegerField('cli_cidade', true)
                )
            );
            $lookupDataset->setOrderByField('cli_nome', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'edit_servicos_serv_cliente_search', 'cli_id', 'cli_nome', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`equipamentos`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('eq_id', true, true, true),
                    new StringField('eq_nome')
                )
            );
            $lookupDataset->setOrderByField('eq_nome', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, '_servicos_serv_equip_search', 'eq_id', 'eq_nome', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`marcas`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('marca_id', true, true, true),
                    new StringField('marca_nome', true)
                )
            );
            $lookupDataset->setOrderByField('marca_nome', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, '_servicos_serv_marca_search', 'marca_id', 'marca_nome', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            
            
            $lookupDataset = new TableDataset(
                MySqlIConnectionFactory::getInstance(),
                GetConnectionOptions(),
                '`bairros`');
            $lookupDataset->addFields(
                array(
                    new IntegerField('bairro_id', true, true, true),
                    new StringField('bairro_nome'),
                    new IntegerField('bairro_cidade', true)
                )
            );
            $lookupDataset->setOrderByField('bairro_nome', 'ASC');
            $handler = new DynamicSearchHandler($lookupDataset, 'insert_servicos_serv_clienteNestedPage_cli_bairro_search', 'bairro_id', 'bairro_nome', null, 20);
            GetApplication()->RegisterHTTPHandler($handler);
            
            
            
            
            
            
            
            
            new servicos_OSItens_item_produtoModalViewPage($this, GetCurrentUserPermissionsForPage('servicos.OSItens.item_produto'));
            new servicos_OSItens_item_produtoNestedPage($this, GetCurrentUserPermissionsForPage('servicos.OSItens.item_produto'));
            new servicos_serv_clienteModalViewPage($this, GetCurrentUserPermissionsForPage('servicos.serv_cliente'));
            new servicos_serv_equipModalViewPage($this, GetCurrentUserPermissionsForPage('servicos.serv_equip'));
            new servicos_serv_marcaModalViewPage($this, GetCurrentUserPermissionsForPage('servicos.serv_marca'));
            new servicos_serv_clienteNestedPage($this, GetCurrentUserPermissionsForPage('servicos.serv_cliente'));
            new servicos_serv_equipNestedPage($this, GetCurrentUserPermissionsForPage('servicos.serv_equip'));
            new servicos_serv_marcaNestedPage($this, GetCurrentUserPermissionsForPage('servicos.serv_marca'));
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
            //gerar cod automatico pro meio da tabela ascii, que usa os decimais de
                    //65 a 90
                    
                    $date = date('ymdHis');
                    $rand = chr(rand(65, 90));
                    $rand .= chr(rand(65, 90));
                    
            $rowData['serv_cod'] = $date . $rand;
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
        $Page = new servicosPage("servicos", "servicos.php", GetCurrentUserPermissionsForPage("servicos"), 'UTF-8');
        $Page->SetRecordPermission(GetCurrentUserRecordPermissionsForDataSource("servicos"));
        GetApplication()->SetMainPage($Page);
        GetApplication()->Run();
    }
    catch(Exception $e)
    {
        ShowErrorPage($e);
    }
	
