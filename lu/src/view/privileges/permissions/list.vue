

<template>
<div id="privileges-users-list">
  <Row type="flex" justify="end" class="code-row-bg" :gutter="16">
    <Col span="3">
    <Input icon="search" placeholder="请输入权限名称..." v-model="searchForm.name" />
    </Col>
    <Col span="2">
    <Button type="primary" icon="ios-search" @click="getTableDataExcute()">Search</Button>
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
    <Table border :columns="columns" :data="dataList"></Table>
  </Row>

  <Modal v-model="addEditPermissionModal.show" :closable='false' :mask-closable=false :width="500">
    <h3 slot="header" style="color:#2D8CF0">编辑权限</h3>
    <Form ref="addEditPermissionForm" :model="addEditPermissionForm" :label-width="100" label-position="right" :rules="ruleAddEditPermission">
      <FormItem label="权限名称" prop="name">
        <Input v-model="addEditPermissionForm.name" placeholder="请输入权限名称"></Input>
      </FormItem>
      <FormItem label="看守器" prop="guard_name">
        <Input v-model="addEditPermissionForm.guard_name" placeholder="请输入看守器"></Input>
      </FormItem>
      <FormItem label="权限描述" prop="description">
        <Input v-model="addEditPermissionForm.description" placeholder="请输入权限描述"></Input>
      </FormItem>

    </Form>
    <div slot="footer">
      <Button type="text" @click="cancelEditPass">取消</Button>
      <Button type="primary" @click="addEditPermissionExcute" :loading="addEditPermissionModal.saveLoading">保存</Button>
    </div>
  </Modal>
</div>
</template>

<script>
import {
  getTableData,
  addEditPermission,
  deletePermission
} from '@/api/permissions'

export default {
  data() {
    return {
      searchForm: {
        name: null,
      },
      tableLoading: false,
      dataList: [],
      modalHeadImage: {
        show: false,
        url: null
      },
      addEditPermissionModal: {
        show: false,
        saveLoading: false,
      },
      ruleAddEditPermission: {
        name: [{
          required: true,
          message: '请填写权限名称',
          trigger: 'blur'
        }],
        guard_name: [{
          required: true,
          message: '请填写看守器',
          trigger: 'blur'
        }],
      },
      addEditPermissionForm: {
        id: 0,
        name: '',
        guard_name: '',
        description: '',
      },
      columns: [{
        title: 'ID',
        key: 'id',
        sortable: true,
        width: 100
      }, {
        title: '权限名称',
        key: 'name'
      }, {
        title: '看守器',
        key: 'guard_name'
      }, {
        title: '权限描述',
        key: 'description'
      }, {
        title: '创建时间',
        key: 'created_at',
        sortable: true,
      }, {
        title: '更新时间',
        key: 'created_at'
      }, {
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
                  t.addEditPermissionForm = t.dataList[params.index]
                  t.addEditPermissionModal.show = true
                }
              }

            }, 'Edit'),
            h('Poptip', {
              props: {
                confirm: true,
                title: '您确定要删除「' + params.row.name + '」权限？',
                transfer: true
              },
              on: {
                'on-ok': () => {
                  t.deletePermissionExcute(params.row.id, params.index)
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
      }, ]
    }
  },
  mounted() {
    this.getTableDataExcute()
  },
  methods: {
    cleanModal() {
      let t = this
      t.addEditPermissionForm = {
        id: 0,
        name: '',
        guard_name: '',
        description: ''
      }
    },
    getTableDataExcute() {
      let t = this
      t.loading = true
      getTableData(t.searchForm).then(res => {
        const response_data = res.data
        t.dataList = response_data
        t.tableLoading = false
      }, function(error) {
        t.tableLoading = false
      })
    },
    addEditPermissionExcute() {
      let t = this
      t.$refs.addEditPermissionForm.validate((valid) => {
        if (valid) {
          t.addEditPermissionModal.saveLoading = true

          addEditPermission(t.addEditPermissionForm).then(res => {
            t.$Notice.success({
              title: '操作成功',
              desc: res.message
            })

            t.getTableDataExcute()
            t.addEditPermissionModal.show = false
            t.addEditPermissionModal.saveLoading = false
          }, function(error) {
            t.addEditPermissionModal.saveLoading = false
          })
        }
      })
    },
    cancelEditPass() {
      let t = this
      t.addEditPermissionModal.show = false
      t.addEditPermissionModal.saveLoading = false
      t.cleanModal()
    },
    addBtn() {
      this.cleanModal()
      this.addEditPermissionModal.show = true
    },
    deletePermissionExcute(permission, key) {
      let t = this
      deletePermission(permission).then(res => {
        t.dataList.splice(key, 1)
        t.$Notice.success({
          title: res.message
        })
      })
    }
  }
}
</script>
