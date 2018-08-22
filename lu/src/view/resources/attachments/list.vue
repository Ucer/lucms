
<template>
<div>
  <Row type="flex" justify="end" class="code-row-bg" :gutter="16">
    <Col span="2">
    <Select v-model="searchForm.use_status" placeholder="请选择使用状态">
      <Option value="" key="">全部</Option>
      <Option v-for="(item,key) in tableStatus.use_status" :value="key" :key="key">{{ item }}</Option>
    </Select>
    </Col>
    <Col span="2">
    <Select v-model="searchForm.enable" placeholder="请选择状态">
        <Option value="" key="">全部</Option>
        <Option v-for="(item,key) in tableStatus.enable" :value="key" :key="key">{{ item }}</Option>
    </Select>
    </Col>
    <Col span="2">
    <Select v-model="searchForm.type" placeholder="请选择附件类型">
        <Option value="" key="">全部</Option>
        <Option v-for="(item,key) in tableStatus.type" :value="key" :key="key">{{ item }}</Option>
    </Select>
    </Col>
    <Col span="2">
    <Select v-model="searchForm.storage_position" placeholder="请选择存储位置">
        <Option value="" key="">全部</Option>
        <Option v-for="(item,key) in tableStatus.storage_position" :value="key" :key="key">{{ item }} </Option>
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
        <Page :total="feeds.total" :current="feeds.current_page" :page-size="feeds.per_page" class="paging" show-elevator show-total show-sizer @on-change="handleOnPageChange"  @on-page-size-change='onPageSizeChange'></Page>
      </div>
    </div>
  </Row>


</div>
</template>


<script>
import ExpandRow from './components/list-table-expand';

import {
  getTableStatus,
  switchEnable
} from '@/api/common'

import {
  getTableData,
  deleteAttachment
} from '@/api/attachment'

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
        enable: [],
        use_status: [],
        type: [],
        storage_position: [],
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
          title: '附件名称',
          key: 'original_name'
        },
        {
          title: '上传者',
          width: 200,
          render: (h, params) => {
            return h('div',
              params.row.user.name
            );
          }
        },
        {
          title: '使用状态',
          width: 150,
          render: (h, params) => {

            const row = params.row;
            const color = row.use_status === 'T' ? 'green' : 'default';
            const text = row.use_status === 'T' ? '使用中' : '未使用';

            return h('div', [
              h('Tag', {
                props: {
                  color: color
                }
              }, text)
            ]);
          }
        },
        {
          title: '附件类型',
          key: 'type',
          width: 100
        },
        {
          title: 'MIME 类型',
          key: 'mime_type',
          width: 100
        },
        {
          title: '存储位置',
          key: 'storage_position',
          width: 100
        },
        {
          title: '大小/kb',
          key: 'size',
          sortable: true,
          width: 100
        },
        {
          title: '启用状态',
          key: 'enable',
          render: (h, params) => {
            return h('i-switch', {
              props: {
                slot: 'open',
                type: 'primary',
                value: params.row.enable === 'T',
              },
              on: {
                'on-change': (value) => {
                  this.switchEnableExcute(params.index)
                }
              }
            });
          }
        },
        {
          title: '创建时间',
          key: 'created_at',
          sortable: true,
        },
        {
          title: '操作',

          render: (h, params) => {
            let t = this;
            return h('div', [
              h('Poptip', {
                props: {
                  confirm: true,
                  title: '您确定要删除「' + params.row.original_name + '」？',
                  transfer: true
                },
                on: {
                  'on-ok': () => {
                    if (params.row.enable === 'T') {
                      t.$Notice.warning({
                        title: '出错了',
                        desc: '启用状态的附件无法删除'
                      });
                    } else {
                      t.deleteAttachmentExcute(params.row.id, params.index);
                    }
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
  mounted() {
    let t = this
    t.getTableStatusExcute('attachments')
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
        t.tableStatus.enable = response_data.enable;
        t.tableStatus.use_status = response_data.use_status;
        t.tableStatus.type = response_data.type;
        t.tableStatus.storage_position = response_data.storage_position;
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
    },
    switchEnableExcute(index) {
      let t = this
      let new_status = 'T'
      if (t.feeds.data[index].enable === 'T') {
        new_status = 'F'
      }
      switchEnable(t.feeds.data[index].id, 'attachments', new_status).then(res => {
        t.feeds.data[index].enable = new_status
        t.$Notice.success({
          title: res.message
        })
      })
    },
    deleteAttachmentExcute(attachment, key) {
      let t = this
      deleteAttachment(attachment).then(res => {
        t.feeds.data.splice(key, 1)
        t.$Notice.success({
          title: res.message
        })
      })
    }
  }
}
</script>
