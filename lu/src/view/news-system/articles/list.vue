
<template>
<div>
  <Row type="flex" justify="end" class="code-row-bg" :gutter="16">
    <Col span="3">
    <Input icon="search" placeholder="请输入标题..." v-model="searchForm.title" />
    </Col>
    <Col span="2">
    <Select v-model="searchForm.enable" placeholder="是否启用">
      <Option value="" key="">全部</Option>
      <Option v-for="(item,key) in tableStatus.enable" :value="key" :key="key">{{ item }}</Option>
    </Select>
    </Col>
    <Col span="2">
    <Select v-model="searchForm.category_id" placeholder="分类" filterable>
      <Option value="" key="">全部</Option>
      <Option v-for="(item,key) in articleCategories" :value="item.id" :key="item.id">{{ item.name }} </Option>
    </Select>
    </Col>
    <Col span="2">
    <Select v-model="searchForm.recommend" placeholder="推荐" filterable>
        <Option value="" key="">全部</Option>
        <Option v-for="(item,key) in tableStatus.recommend" :value="key" :key="key">{{ item }} </Option>
    </Select>
    </Col>
    <Col span="2">
    <Select v-model="searchForm.top" placeholder="置顶" filterable>
        <Option value="" key="">全部</Option>
        <Option v-for="(item,key) in tableStatus.top" :value="key" :key="key">{{ item }} </Option>
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
        <Page :total="feeds.total" :current="feeds.current_page" :page-size="feeds.per_page" class="paging" show-elevator show-total show-sizer @on-change="handleOnPageChange"></Page>
      </div>
    </div>
  </Row>

  <add-component v-if='addModal.show === true' @on-add-modal-success='getTableDataExcute(1)' @on-add-modal-hide="addModalHide" :article-categories='articleCategories'></add-component>
  <edit-component v-if='editModal.show === true' :modal-id='editModal.id' @on-edit-modal-success='getTableDataExcute(1)' @on-edit-modal-hide="editModalHide" :article-categories='articleCategories'> </edit-component>

</div>
</template>


<script>
import AddComponent from './components/add-article'
import EditComponent from './components/edit-article'
import ExpandRow from './components/list-table-expand';

import {
  getTableStatus,
  switchEnable
} from '@/api/common'

import {
  getTableData,
  getArticleCategories,
  deleteArticle
} from '@/api/article'

export default {
  components: {
    AddComponent,
    EditComponent,
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
        top: [],
        recommend: [],
      },
      feeds: {
        data: [],
        total: 0,
        current_page: 1,
        per_page: 10
      },
      articleCategories: {},
      addModal: {
        show: false
      },
      editModal: {
        show: false,
        id: 0
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
          sortable: true,
          width: 100
        },
        {
          title: '标题',
          key: 'title',
          width: 150,
        },
        {
          title: '封面',
          width: 150,
          render: (h, params) => {
            let t = this;
            if (params.row.cover_image.url) {
              return h('div', [
                h('img', {
                  attrs: {
                    src: params.row.cover_image.url,
                  },
                  style: {
                    width: '40px',
                    height: '40px'
                  },
                  on: {
                    click: (value) => {
                      t.modalHeadImage.show = true;
                      t.modalHeadImage.url = params.row.cover_image.url;
                    }
                  }
                }),
              ]);
            }
          }
        },
        {
          title: '分类',
          width: 100,
          render: (h, params) => {
            return h('div',
              params.row.category.name
            )
          }
        },
        {
          title: '标签',
          width: 200,
          render: (h, params) => {
            var tags = params.row.tags;
            var text = '';
            for (var key in tags) {
              if (key < 1) {
                text += tags[key].name
              } else {
                text += '、' + tags[key].name
              }
            }
            return h('div',
              text
            )
          }
        },
        {
          title: '置顶',
          width: 150,
          render: (h, params) => {
            var row = params.row;
            var color = 'green';
            var text = '置顶';
            if (row.top === 'F') {
              text = '非置顶';
              color = 'default';
            }

            return h('div', [
              h('Tag', {
                props: {
                  type: 'dot',
                  color: color
                }
              }, text)
            ]);
          }
        },
        {
          title: '推荐',
          width: 150,
          render: (h, params) => {
            var row = params.row;
            var color = 'green';
            var text = '推荐';
            if (row.recommend === 'F') {
              text = '非推荐';
              color = 'default';
            }

            return h('div', [
              h('Tag', {
                props: {
                  type: 'dot',
                  color: color
                }
              }, text)
            ]);
          }
        },
        {
          title: '启用状态',
          key: 'enable',
          render: (h, params) => {
            return h('i-switch', {
              props: {
                slot: 'open',
                type: 'primary',
                value: params.row.enable === 'T', //控制开关的打开或关闭状态，官网文档属性是value
              },
              on: {
                'on-change': (value) => {
                  this.switchEnable(params.index)
                }
              }
            });
          }
        },
        {
          title: '创建时间',
          sortable: true,
          key: 'created_at'
        },
        {
          title: '操作',
          render: (h, params) => {
            let t = this;
            let canAccess = t.canAccess;
            var delete_btn = '';

            if (canAccess) {
              delete_btn = h('Poptip', {
                props: {
                  confirm: true,
                  title: '您确定要删除「' + params.row.name + '」？',
                  transfer: true
                },
                on: {
                  'on-ok': () => {
                    t.deleteBtn(params.row.id, params.index);
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
            }
            return h('div', [
              h('Button', {
                props: {
                  type: 'success',
                  size: 'small'
                },
                on: {
                  click: () => {
                    this.$router.push({
                      name: 'edit-article',
                      params: {
                        article_id: params.row.id
                      }
                    });
                  }
                }

              }, 'Edit'),
              delete_btn
            ])
          }
        }
      ]
    }
  },
  created() {
    let t = this
    t.getTableStatusExcute('articles')
    t.getArticleCategoriesExcute()
    t.getTableDataExcute(t.feeds.current_page)
  },
  methods: {
    handleOnPageChange: function(to_page) {
      this.getTableDataExcute(to_page)
    },
    getTableStatusExcute(params) {
      let t = this
      getTableStatus(params).then(res => {
        const response_data = res.data
        t.tableStatus.enable = response_data.enable;
        t.tableStatus.recommend = response_data.recommend;
        t.tableStatus.top = response_data.top;
      })
    },
    getArticleCategoriesExcute() {
      let t = this
      getArticleCategories().then(res => {
        t.articleCategories = res.data;
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
      switchEnable(t.feeds.data[index].id, 'articles', new_status).then(res => {
        t.feeds.data[index].enable = new_status
        t.$Notice.success({
          title: res.message
        })
      })
    },
    deleteArticleExcute(article, key) {
      let t = this
      deleteArticle(article).then(res => {
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
