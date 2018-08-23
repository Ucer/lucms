
<template>
<div>
  <Row type="flex" justify="end" class="code-row-bg" :gutter="16">
    <Col span="3">
    <Input icon="search" placeholder="请输入昵称..." v-model="searchForm.user_name" />
    </Col>
    <Col span="2">
    <Select v-model="searchForm.type" placeholder="日志类型">
        <Option value="" key="">全部类型</Option>
        <Option v-for="(item,key) in tableStatus.type" :value="key" :key="key">{{ item }}</Option>
    </Select>
    </Col>
    <Col span="3">
    <Select v-model="searchForm.table_name" placeholder="表" filterable>
        <Option value="" key="">全部表</Option>
        <Option v-for="(item,key) in tableStatus.table_name" :value="key" :key="key">{{ item }} </Option>
    </Select>
    </Col>
    <Col span="2">
    <Button type="primary" icon="ios-search" @click="getTableDataExcute(1)">Search</Button>
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


</div>
</template>


<script>
import ExpandRow from './components/list-table-expand'

import {
  getTableStatus
} from '@/api/common'

import {
  getTableData
} from '@/api/log'

export default {
  components: {
    ExpandRow
  },
  data() {
    return {
      searchForm: {
        order_by: 'id,desc'
      },
      tableLoading: false,
      tableStatus: {
        type: [],
        table_name: [],
      },
      feeds: {
        data: [],
        total: 0,
        current_page: 1,
        per_page: 10
      },
      columns: [{
          title: '>>',
          type: 'expand',
          width: 50,
          render: (h, params) => {
            return h(ExpandRow, {
              props: {
                row: params.row
              }
            })
          }
        },
        {
          title: 'ID',
          key: 'id',
          sortable: 'customer',
          width: 100
        },
        {
          title: '操作人',
          key: 'id',
          render: (h, params) => {
            return h('div', {
                class: 'green-color',
              },
              params.row.user.name + '--' + params.row.user.email
            )
          }
        },
        {
          title: '类型',
          render: (h, params) => {
            return h('div',
              this.tableStatus.type[params.row.type]
            )
          }
        },
        {
          title: '表',
          render: (h, params) => {
            return h('div',
              this.tableStatus.table_name[params.row.table_name]
            )
          }
        },
        {
          title: 'IP',
          key: 'ip',
          width: 150
        },
        {
          title: '创建时间',
          sortable: true,
          key: 'created_at'
        },
      ]
    }
  },
  mounted() {
    let t = this
    t.getTableStatusExcute('logs')
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
        const response_data = res.data
        t.tableStatus.type = response_data.type
        t.tableStatus.table_name = response_data.table_name
      })
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
    onSortChange: function(data) {
      const order = data.column.key + ',' + data.order
      this.searchForm.order_by = order
      this.getTableDataExcute(1)
    }
  }
}
</script>
