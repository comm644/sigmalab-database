#define FFI_SCOPE "sqlite3"
#define FFI_LIB  "libsqlite3.so"


extern const char sqlite3_version[];
const char *sqlite3_libversion(void);
const char *sqlite3_sourceid(void);
int sqlite3_libversion_number(void);
int sqlite3_compileoption_used(const char *zOptName);
const char *sqlite3_compileoption_get(int N);
int sqlite3_threadsafe(void);

typedef struct sqlite3 sqlite3;
typedef long long int sqlite_int64;
typedef unsigned long long int sqlite_uint64;
typedef sqlite_int64 sqlite3_int64;
typedef sqlite_uint64 sqlite3_uint64;
int sqlite3_close(sqlite3*);
int sqlite3_close_v2(sqlite3*);


typedef struct sqlite3_file sqlite3_file;

typedef struct sqlite3_mutex sqlite3_mutex;
typedef struct sqlite3_api_routines sqlite3_api_routines;
typedef struct sqlite3_vfs sqlite3_vfs;


int sqlite3_initialize(void);
int sqlite3_shutdown(void);
int sqlite3_os_init(void);
int sqlite3_os_end(void);
int sqlite3_config(int, ...);
int sqlite3_db_config(sqlite3* s, int op, ...);


int sqlite3_extended_result_codes(sqlite3*, int onoff);
sqlite3_int64 sqlite3_last_insert_rowid(sqlite3*);
void sqlite3_set_last_insert_rowid(sqlite3* db,sqlite3_int64 n);
int sqlite3_changes(sqlite3*);
int sqlite3_total_changes(sqlite3*);
void sqlite3_interrupt(sqlite3*);
int sqlite3_complete(const char *sql);
int sqlite3_complete16(const void *sql);


int sqlite3_busy_timeout(sqlite3*, int ms);
int sqlite3_get_table(
  sqlite3 *db,
  const char *zSql,
  char ***pazResult,
  int *pnRow,
  int *pnColumn,
  char **pzErrmsg
);
void sqlite3_free_table(char **result);

void *sqlite3_malloc(int);
void *sqlite3_malloc64(sqlite3_uint64);
void *sqlite3_realloc(void* ptr, int n);
void *sqlite3_realloc64(void* ptr, sqlite3_uint64 n);
void sqlite3_free(void*);
sqlite3_uint64 sqlite3_msize(void*);
sqlite3_int64 sqlite3_memory_used(void);
sqlite3_int64 sqlite3_memory_highwater(int resetFlag);
void sqlite3_randomness(int N, void *P);


int sqlite3_open(
  const char *filename,
  sqlite3 **ppDb
);
int sqlite3_open16(
  const void *filename,
  sqlite3 **ppDb
);
int sqlite3_open_v2(
  const char *filename,
  sqlite3 **ppDb,
  int flags,
  const char *zVfs
);
const char *sqlite3_uri_parameter(const char *zFilename, const char *zParam);
int sqlite3_uri_boolean(const char *zFile, const char *zParam, int bDefault);
sqlite3_int64 sqlite3_uri_int64(const char* s1, const char* s2, sqlite3_int64 s3);
const char *sqlite3_uri_key(const char *zFilename, int N);
const char *sqlite3_filename_database(const char* s1);
const char *sqlite3_filename_journal(const char* s1);
const char *sqlite3_filename_wal(const char* s1);
int sqlite3_errcode(sqlite3 *db);
int sqlite3_extended_errcode(sqlite3 *db);
const char *sqlite3_errmsg(sqlite3* db);
const void *sqlite3_errmsg16(sqlite3* db);
const char *sqlite3_errstr(int errno);

typedef struct sqlite3_stmt sqlite3_stmt;
int sqlite3_limit(sqlite3* db, int id, int newVal);
int sqlite3_prepare(sqlite3 *db, const char *zSql, int nByte, sqlite3_stmt **ppStmt,  char **pzTail);
int sqlite3_prepare_v2(
  sqlite3 *db,
  const char *zSql,
  int nByte,
  sqlite3_stmt **ppStmt,
  const char **pzTail
);
int sqlite3_prepare_v3(
  sqlite3 *db,
  const char *zSql,
  int nByte,
  unsigned int prepFlags,
  sqlite3_stmt **ppStmt,
  const char **pzTail
);
int sqlite3_prepare16(
  sqlite3 *db,
  const void *zSql,
  int nByte,
  sqlite3_stmt **ppStmt,
  const void **pzTail
);
int sqlite3_prepare16_v2(
  sqlite3 *db,
  const void *zSql,
  int nByte,
  sqlite3_stmt **ppStmt,
  const void **pzTail
);
int sqlite3_prepare16_v3(
  sqlite3 *db,
  const void *zSql,
  int nByte,
  unsigned int prepFlags,
  sqlite3_stmt **ppStmt,
  const void **pzTail
);
const char *sqlite3_sql(sqlite3_stmt *pStmt);
char *sqlite3_expanded_sql(sqlite3_stmt *pStmt);
int sqlite3_stmt_readonly(sqlite3_stmt *pStmt);
int sqlite3_stmt_isexplain(sqlite3_stmt *pStmt);
int sqlite3_stmt_busy(sqlite3_stmt* pStmt);
typedef struct sqlite3_value sqlite3_value;
typedef struct sqlite3_context sqlite3_context;

int sqlite3_bind_double(sqlite3_stmt* pStmt, int i, double d);
int sqlite3_bind_int(sqlite3_stmt* pStmt, int i, int i2);
int sqlite3_bind_int64(sqlite3_stmt* pStmt, int i, sqlite3_int64 i2);
int sqlite3_bind_null(sqlite3_stmt* pStmt, int i);


int sqlite3_bind_value(sqlite3_stmt* pStmt, int i, const sqlite3_value* v);


int sqlite3_bind_zeroblob(sqlite3_stmt* pStmt, int i, int n);
int sqlite3_bind_zeroblob64(sqlite3_stmt* pStmt, int, sqlite3_uint64 i);
int sqlite3_bind_parameter_count(sqlite3_stmt* pStmt);
const char *sqlite3_bind_parameter_name(sqlite3_stmt* pStmt, int i);
int sqlite3_bind_parameter_index(sqlite3_stmt* pStmt, const char *zName);
int sqlite3_clear_bindings(sqlite3_stmt* pStmt);
int sqlite3_column_count(sqlite3_stmt *pStmt);
const char *sqlite3_column_name(sqlite3_stmt* pStmt, int N);
const void *sqlite3_column_name16(sqlite3_stmt* pStmt, int N);
const char *sqlite3_column_database_name(sqlite3_stmt* pStmt, int N);
const void *sqlite3_column_database_name16(sqlite3_stmt* pStmt, int N);
const char *sqlite3_column_table_name(sqlite3_stmt* pStmt, int N);
const void *sqlite3_column_table_name16(sqlite3_stmt* pStmt,int N);
const char *sqlite3_column_origin_name(sqlite3_stmt* pStmt,int N);
const void *sqlite3_column_origin_name16(sqlite3_stmt* pStmt,int N);
const char *sqlite3_column_decltype(sqlite3_stmt* pStmt,int N);
const void *sqlite3_column_decltype16(sqlite3_stmt* pStmt,int N);
int sqlite3_step(sqlite3_stmt* pStmt);
int sqlite3_data_count(sqlite3_stmt *pStmt);
const void *sqlite3_column_blob(sqlite3_stmt* pStmt, int iCol);
double sqlite3_column_double(sqlite3_stmt* pStmt, int iCol);
int sqlite3_column_int(sqlite3_stmt* pStmt, int iCol);
sqlite3_int64 sqlite3_column_int64(sqlite3_stmt* pStmt, int iCol);
const unsigned char *sqlite3_column_text(sqlite3_stmt* pStmt, int iCol);
const void *sqlite3_column_text16(sqlite3_stmt* pStmt, int iCol);
struct sqlite3_value* sqlite3_column_value(sqlite3_stmt* pStmt, int iCol);
int sqlite3_column_bytes(sqlite3_stmt* pStmt, int iCol);
int sqlite3_column_bytes16(sqlite3_stmt* pStmt, int iCol);
int sqlite3_column_type(sqlite3_stmt* pStmt, int iCol);
int sqlite3_finalize(sqlite3_stmt *pStmt);
int sqlite3_reset(sqlite3_stmt *pStmt);

int sqlite3_aggregate_count(sqlite3_context* ctx);
int sqlite3_expired(sqlite3_stmt* pStmt);
int sqlite3_transfer_bindings(sqlite3_stmt* pStmt1, sqlite3_stmt* pStmt2);
int sqlite3_global_recover(void);
void sqlite3_thread_cleanup(void);

const char *sqlite3_value_blob(sqlite3_value*);
double sqlite3_value_double(sqlite3_value*);
int sqlite3_value_int(sqlite3_value*);
sqlite3_int64 sqlite3_value_int64(sqlite3_value*);
void *sqlite3_value_pointer(sqlite3_value* v, const char* str);
const char *sqlite3_value_text(sqlite3_value*);
const void *sqlite3_value_text16(sqlite3_value*);
const void *sqlite3_value_text16le(sqlite3_value*);
const void *sqlite3_value_text16be(sqlite3_value*);
int sqlite3_value_bytes(sqlite3_value*);
int sqlite3_value_bytes16(sqlite3_value*);
int sqlite3_value_type(sqlite3_value*);
int sqlite3_value_numeric_type(sqlite3_value*);
int sqlite3_value_nochange(sqlite3_value*);
int sqlite3_value_frombind(sqlite3_value*);
unsigned int sqlite3_value_subtype(sqlite3_value*);
sqlite3_value *sqlite3_value_dup(const sqlite3_value*);
void sqlite3_value_free(sqlite3_value*);
void *sqlite3_aggregate_context(sqlite3_context* ctx, int nBytes);
void *sqlite3_user_data(sqlite3_context*);
sqlite3 *sqlite3_context_db_handle(sqlite3_context*);
void *sqlite3_get_auxdata(sqlite3_context* ctx, int N);

void sqlite3_result_double(sqlite3_context* ctx, double d);
void sqlite3_result_error(sqlite3_context* ctx, const char* s, int n);
void sqlite3_result_error16(sqlite3_context* ctx, const void* v, int n);
void sqlite3_result_error_toobig(sqlite3_context* ctx);
void sqlite3_result_error_nomem(sqlite3_context* ctx);
void sqlite3_result_error_code(sqlite3_context* ctx, int n);
void sqlite3_result_int(sqlite3_context* ctx, int n);
void sqlite3_result_int64(sqlite3_context* ctx, sqlite3_int64 n);
void sqlite3_result_null(sqlite3_context* ctx);
void sqlite3_result_value(sqlite3_context* ctx, sqlite3_value* v);
void sqlite3_result_zeroblob(sqlite3_context* ctx, int n);
int sqlite3_result_zeroblob64(sqlite3_context* ctx, sqlite3_uint64 n);
void sqlite3_result_subtype(sqlite3_context* ctx,unsigned int n);

int sqlite3_sleep(int);
extern char *sqlite3_temp_directory;
extern char *sqlite3_data_directory;


int sqlite3_get_autocommit(sqlite3* db);
sqlite3 *sqlite3_db_handle(sqlite3_stmt* pStmt);
const char *sqlite3_db_filename(sqlite3 *db, const char *zDbName);
int sqlite3_db_readonly(sqlite3 *db, const char *zDbName);
sqlite3_stmt *sqlite3_next_stmt(sqlite3 *pDb, sqlite3_stmt *pStmt);

int sqlite3_enable_shared_cache(int);
int sqlite3_release_memory(int);
int sqlite3_db_release_memory(sqlite3* db);
sqlite3_int64 sqlite3_soft_heap_limit64(sqlite3_int64 N);
sqlite3_int64 sqlite3_hard_heap_limit64(sqlite3_int64 N);
void sqlite3_soft_heap_limit(int N);
int sqlite3_table_column_metadata(
  sqlite3 *db,
  const char *zDbName,
  const char *zTableName,
  const char *zColumnName,
  char const **pzDataType,
  char const **pzCollSeq,
  int *pNotNull,
  int *pPrimaryKey,
  int *pAutoinc
);
int sqlite3_load_extension(
  sqlite3 *db,
  const char *zFile,
  const char *zProc,
  char **pzErrMsg
);
int sqlite3_enable_load_extension(sqlite3 *db, int onoff);
void sqlite3_reset_auto_extension(void);
typedef struct sqlite3_vtab sqlite3_vtab;
typedef struct sqlite3_index_info sqlite3_index_info;
typedef struct sqlite3_vtab_cursor sqlite3_vtab_cursor;
typedef struct sqlite3_module sqlite3_module;

struct sqlite3_index_info {
  int nConstraint;
  struct sqlite3_index_constraint {
    int iColumn;
    unsigned char op;
    unsigned char usable;
    int iTermOffset;
  } *aConstraint;
  int nOrderBy;
  struct sqlite3_index_orderby {
    int iColumn;
    unsigned char desc;
  } *aOrderBy;
  struct sqlite3_index_constraint_usage {
    int argvIndex;
    unsigned char omit;
  } *aConstraintUsage;
  int idxNum;
  char *idxStr;
  int needToFreeIdxStr;
  int orderByConsumed;
  double estimatedCost;
  sqlite3_int64 estimatedRows;
  int idxFlags;
  sqlite3_uint64 colUsed;
};
int sqlite3_create_module(
  sqlite3 *db,
  const char *zName,
  const sqlite3_module *p,
  void *pClientData
);

int sqlite3_drop_modules(
  sqlite3 *db,
  const char **azKeep
);
struct sqlite3_vtab {
  const sqlite3_module *pModule;
  int nRef;
  char *zErrMsg;
};
struct sqlite3_vtab_cursor {
  sqlite3_vtab *pVtab;
};
int sqlite3_declare_vtab(sqlite3*, const char *zSQL);
int sqlite3_overload_function(sqlite3*, const char *zFuncName, int nArg);
typedef struct sqlite3_blob sqlite3_blob;
int sqlite3_blob_open(
  sqlite3*,
  const char *zDb,
  const char *zTable,
  const char *zColumn,
  sqlite3_int64 iRow,
  int flags,
  sqlite3_blob **ppBlob
);
int sqlite3_blob_reopen(sqlite3_blob *b, sqlite3_int64 i);
int sqlite3_blob_close(sqlite3_blob *b);
int sqlite3_blob_bytes(sqlite3_blob *b);
int sqlite3_blob_read(sqlite3_blob *b, void *Z, int N, int iOffset);
int sqlite3_blob_write(sqlite3_blob *b, const void *z, int n, int iOffset);
sqlite3_vfs *sqlite3_vfs_find(const char *zVfsName);
int sqlite3_vfs_register(sqlite3_vfs *v, int makeDflt);
int sqlite3_vfs_unregister(sqlite3_vfs *v);
sqlite3_mutex *sqlite3_mutex_alloc(int);
void sqlite3_mutex_free(sqlite3_mutex *m);
void sqlite3_mutex_enter(sqlite3_mutex *m);
int sqlite3_mutex_try(sqlite3_mutex *m);
void sqlite3_mutex_leave(sqlite3_mutex *m);
typedef struct sqlite3_mutex_methods sqlite3_mutex_methods;

/*
 int sqlite3_mutex_held(sqlite3_mutex*);
 int sqlite3_mutex_notheld(sqlite3_mutex*);
 */
sqlite3_mutex *sqlite3_db_mutex(sqlite3*);
int sqlite3_file_control(sqlite3* db, const char *zDbName, int op, void* p);
int sqlite3_test_control(int op, ...);
int sqlite3_keyword_count(void);
int sqlite3_keyword_name(int i,const char** s,int* p);
int sqlite3_keyword_check(const char* s,int p);
typedef struct sqlite3_str sqlite3_str;
sqlite3_str *sqlite3_str_new(sqlite3*);
char *sqlite3_str_finish(sqlite3_str*);
void sqlite3_str_reset(sqlite3_str*);
int sqlite3_str_errcode(sqlite3_str*);
int sqlite3_str_length(sqlite3_str*);
char *sqlite3_str_value(sqlite3_str*);
int sqlite3_status(int op, int *pCurrent, int *pHighwater, int resetFlag);
int sqlite3_status64(
  int op,
  sqlite3_int64 *pCurrent,
  sqlite3_int64 *pHighwater,
  int resetFlag
);
int sqlite3_db_status(sqlite3*, int op, int *pCur, int *pHiwtr, int resetFlg);
int sqlite3_stmt_status(sqlite3_stmt*, int op,int resetFlg);
typedef struct sqlite3_pcache sqlite3_pcache;
typedef struct sqlite3_pcache_page sqlite3_pcache_page;
struct sqlite3_pcache_page {
  void *pBuf;
  void *pExtra;
};
typedef struct sqlite3_pcache_methods2 sqlite3_pcache_methods2;

typedef struct sqlite3_pcache_methods sqlite3_pcache_methods;

typedef struct sqlite3_backup sqlite3_backup;
sqlite3_backup *sqlite3_backup_init(
  sqlite3 *pDest,
  const char *zDestName,
  sqlite3 *pSource,
  const char *zSourceName
);
int sqlite3_backup_step(sqlite3_backup *p, int nPage);
int sqlite3_backup_finish(sqlite3_backup *p);
int sqlite3_backup_remaining(sqlite3_backup *p);
int sqlite3_backup_pagecount(sqlite3_backup *p);

int sqlite3_stricmp(const char *s1, const char *s2);
int sqlite3_strnicmp(const char *s1, const char *s2, int n);
int sqlite3_strglob(const char *zGlob, const char *zStr);
int sqlite3_strlike(const char *zGlob, const char *zStr, unsigned int cEsc);
void sqlite3_log(int iErrCode, const char *zFormat, ...);



int sqlite3_db_cacheflush(sqlite3*);
int sqlite3_system_errno(sqlite3*);
typedef struct sqlite3_snapshot {
  unsigned char hidden[48];
} sqlite3_snapshot;



int sqlite3_bind_blob(sqlite3_stmt* s, int idx, const char* content, int size, int func);
int sqlite3_bind_text(sqlite3_stmt* s, int idx, const char* content, int size, int func);
