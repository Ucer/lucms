<template>
<div>
  <Row type="flex" justify="end" class="code-row-bg" :gutter="16">
    <Col span="3">
    <Input icon="searchForm" placeholder="请输入广告位名称..." v-model="searchForm.name" />
    </Col>
    <Col span="3">
    <Select v-model="searchForm.type" placeholder="请选择广告位类型">
        <Option value="" key="">全部</Option>
        <Option v-for="(item,key) in tableStatus.type" :value="key" :key="key">{{ item }}</Option>
    </Select>
    </Col>
    <Col span="2">
    <Button type="primary" icon="ios-search" @click="getTableDataExcute(1)">Search</Button>
    </Col>
    <Col span="2">
    <Button type="success" icon="plus" @click="addBtn()">Add</Button>
    </Col>
  </Row>
  <br>

  <Row>
    <div class="demo-spin-container" v-if="tableLoading">
      <Spin fix>
        <Icon type="load-c" size=18 class="spin-icon-load"></Icon>
        <div>加载中...</div>
      </Spin>
    </div>
    <Table border :columns="columns" :data="feeds.data" @on-sort-change='onSortChange'></Table>
    <div style="margin: 10px;overflow: hidden">
      <div style="float: right;">
        <Page :total="feeds.total" :current="feeds.current_page" :page-size="feeds.per_page" class="paging" show-elevator show-total show-sizer @on-change="handleOnPageChange" @on-page-size-change='onPageSizeChange'></Page>
      </div>
    </div>
  </Row>

  <add-component v-if='addModal.show === true' @on-add-modal-success='getTableDataExcute(1)' @on-add-modal-hide="addModalHide" :table-status='tableStatus'></add-component>
  <edit-component v-if='editModal.show === true' :modal-id='editModal.id' @on-edit-modal-success='getTableDataExcute(1)' @on-edit-modal-hide="editModalHide" :table-status='tableStatus'> </edit-component>

</div>
</template>


<script>
import AddComponent from './components/add-advertisement-position'
import EditComponent from './components/edit-advertisement-position'

import {
  getTableStatus
} from '@/api/common'

import {
  getTableData,
  deleteAdvertisementPosition
} from '@/api/advertisement-position'

export default {
  components: {
    AddComponent,
    EditComponent
  },
  data() {
    return {
      searchForm: {
        order_by: 'id,desc'
      },
      tableLoading: false,
      tableStatus: {
        type: []
      },
      feeds: {
        data: [],
        total: 0,
        current_page: 1,
        per_page: 10
      },
      addModal: {
        show: false
      },
      editModal: {
        show: false,
        id: 0
      },
      columns: [{
          title: 'ID',
          key: 'id',
          sortable: 'customer',
          width: 100
        },
        {
          title: '广告位名称',
          key: 'name'
        },
        {
          title: '广告位描述',
          key: 'description'
        },
        {
          title: '类型',
          render: (h, params) => {
            return h('div', [
              h('Tag', {
                props: {
                  color: 'green'
                }
              }, this.tableStatus.type[params.row.type])
            ])
          },
        },
        {
          title: '创建时间',
          key: 'created_at',
        },
        {
          title: '更新时间',
          key: 'created_at'
        },
        {
          title: '操作',
          render: (h, params) => {
            let t = this
            return h('div', [
              h('Button', {
                props: {
                  type: 'success',
                  size: 'small'
                },
                on: {
                  click: () => {
                    this.editModal.show = true
                    this.editModal.id = params.row.id
                  }
                }

              }, 'Edit'),
              h('Poptip', {
                props: {
                  confirm: true,
                  title: '您确定要删除「' + params.row.name + '」广告位？',
                  transfer: true
                },
                on: {
                  'on-ok': () => {
                    t.deleteAdvertisementPositionExcute(params.row.id, params.index)
                  }
                }
              }, [
                h('Button', {
                  style: {
                    margin: '0 5px'
                  },
                  props: {
                    type: 'error',
                    size: 'small',
                    placement: 'top'
                  }
                }, '删除'),
              ])

            ])
          }
        },
      ]
    }
  },
  created() {
    let t = this
    t.getTableStatusExcute('advertisement_positions/type')
    t.getTableDataExcute(t.feeds.current_page)
  },
  methods: {
    handleOnPageChange: function(to_page) {
      this.getTableDataExcute(to_page)
    },
    onPageSizeChange: function(per_page) {
      this.feeds.per_page = per_page
      this.getTableDataExcute(1)
    },
    getTableStatusExcute(params) {
      let t = this
      getTableStatus(params).then(res => {
        t.tableStatus.type = res.data
      })
    },
    onSortChange: function(data) {
      const order = data.column.key + ',' + data.order
      this.searchForm.order_by = order
      this.getTableDataExcute()
    },
    getTableDataExcute(to_page) {
      let t = this
      t.tableLoading = true
      t.feeds.current_page = to_page
      getTableData(to_page, t.feeds.per_page, t.searchForm).then(res => {
        t.feeds.data = res.data
        t.feeds.total = res.meta.total
        t.tableLoading = false
      }, function(error) {
        t.tableLoading = false
      })
    },
    deleteAdvertisementPositionExcute(advertisementPosition, key) {
      let t = this
      deleteAdvertisementPosition(advertisementPosition).then(res => {
        t.feeds.data.splice(key, 1)
        t.$Notice.success({
          title: res.message
        })
      })
    },
    addBtn() {
      this.addModal.show = true
    },
    addModalHide() {
      this.addModal.show = false
    },
    editModalHide() {
      this.editModal.show = false
    }
  }
}
</script>
