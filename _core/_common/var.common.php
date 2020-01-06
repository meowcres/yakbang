<?
/* DB TABLE */
/* 사이트 환경 관련 테이블 */
$TB_CONFIG = SITE_KEY . "_CONFIG"; // 사이트 환경 테이블
$TB_ADMIN = SITE_KEY . "_ADMIN"; // 관리자 정보 테이블
$TB_BAN_WORD = SITE_KEY . "_BAN_WORD"; // 금지어 테이블
$TB_CODE = SITE_KEY . "_CODE"; // 코드 테이블
$TB_AD = SITE_KEY . "_AD"; // 광고 테이블


/* 회원 관련 테이블 */
$TB_STIPULATION = SITE_KEY . "_STIPULATION"; // 회원약관 및 개인보호정책 테이블
$TB_MEMBER = SITE_KEY . "_MEMBER"; // 회원메인 테이블
$TB_MEMBER_INFO = SITE_KEY . "_MEMBER_INFORMATION"; // 회원정보 테이블


/* 약국 관련 테이블 */
$TB_PHARMACY = SITE_KEY . "_PHARMACY"; // 약국 테이블
$TB_PP = SITE_KEY . "_PHARMACY_PHARMACIST"; // 약국 소속 약사 정보 테이블
$TB_AP = SITE_KEY . "_APPLY_PHARMACY"; // 약국 신청 정보 테이블
$TB_MENTOR = SITE_KEY . "_MENTOR"; // 멘토 테이블


/* 커뮤니티 관련 테이블 */
$TB_NOTICE = SITE_KEY . "_NOTICE"; // 공지사항 테이블
$TB_FAQ = SITE_KEY . "_FAQ"; // FAQ 테이블
$TB_REQUEST = SITE_KEY . "_REQUEST"; // 문의 테이블
$TB_PORTFOLIO = SITE_KEY . "_PORTFOLIO"; // 포트폴리오 테이블


/* 처방전 관련 테이블 */
$TB_PS = SITE_KEY . "_PRESCRIPTION"; // 처방전 테이블
$TB_PS_PILL = SITE_KEY . "_PRESCRIPTION_PILL"; // 처방 약품 테이블
$TB_PS_PHARMACY = SITE_KEY . "_PRESCRIPTION_PHARMACY"; // 처방전 전송 약국 테이블
$TB_PS_IMAGE = SITE_KEY . "_PRESCRIPTION_IMAGE"; // 처방전 이미지 테이블
$TB_PS_CNT = SITE_KEY . "_PRESCRIPTION_COUNT"; // 처방전 카운터 테이블

/* 상담 관련 테이블 */
$TB_COUNSEL = SITE_KEY . "_COUNSEL"; // 상담 테이블
$TB_CR = SITE_KEY . "_COUNSEL_REPLY"; // 상담 댓글 테이블

/* 쪽지 관련 테이블 */
$TB_DM = SITE_KEY . "_DM"; // 쪽지 테이블

/* 푸시 관련 테이블 */
$TB_PUSH = SITE_KEY . "_PUSH"; // 푸시 테이블
$TB_PUSH_TMP = SITE_KEY . "_PUSH_TMP"; // 푸시 임시 테이블
$TB_FCM = SITE_KEY . "_FCM"; // FCM 신청 테이블
$TB_FCM_VIEW = SITE_KEY . "_FCM_VIEW"; // FCM 확인 테이블

/* 공통 파일 관련 테이블 */
$TB_ATTECH_FILES    = SITE_KEY . "_ATTACH_FILES"; // 파일 테이블
$TB_ATTECH_CONTENTS = SITE_KEY . "_ATTACH_CONTENTS"; // 컨텐츠 테이블


/* 조작자 테이블 */
$TB_OP = SITE_KEY . "_OPERATOR"; // 조작자 테이블
$TB_OP_LOG = SITE_KEY . "_OPERATOR_LOG_HISTORY"; // 조작자 로그 테이블
$TB_PS_PRECLEANING = SITE_KEY . "_PRESCRIPTION_PRECLEANING"; // 조작자 처방전 테이블


/* 처방약 테이블 */
$TB_PILL = SITE_KEY . "_PILL"; // 처방약 테이블



/**
 * 회원 구분 배열
 **/
$member_type_array = array(
    "1" => "일반회원",
    "2" => "전문약사"
);
reset($member_type_array);


/**
 * 회원 상태 배열
 **/
$member_status_array = array(
    "1" => "활동",
    "2" => "휴면",
    "3" => "탈퇴",
    "4" => "블랙",
    "5" => "보류",
    "6" => "정지"
);
reset($member_status_array);


/**
 * 약국 상태 배열
 **/
$pharmacy_status_array = array(
    "1" => "대기",
    "2" => "불가",
    "3" => "완료",
    "4" => "활동",
    "5" => "정지",
    "6" => "블랙",
    "7" => "폐업"
);
reset($pharmacy_status_array);


/**
 * 약국의 전문약사 상태
 **/
$pharmacist_status_array = array(
    "1" => "약사활동",
    "2" => "소속신청중",
    "3" => "신청보류",
    "4" => "활동정지",
    "5" => "활동보류"
);
reset($pharmacist_status_array);


/**
 * 약국의 전문약사 등급
 **/
$pharmacist_grade_array = array(
    "1" => "협동약사",
    "2" => "메인약사"
);
reset($pharmacist_grade_array);


/**
 * 처방전 상태
 **/
$prescription_status_array = array(
    "1" => "처리중",
    "2" => "판독불가",
    "3" => "진행중",
    "4" => "결제불가",
    "5" => "결제완료",
    "6" => "전송취소",
    "9" => "준비단계"
);
reset($prescription_pill_type_array);

/**
 * 처방전 타입
 **/
$prescription_type_array = array(
    "1" => "처방전코드",
    "2" => "QR코드"
);
reset($prescription_pill_type_array);


/**
 * 처방전 약품 타입
 **/
$prescription_pill_type_array = array(
    "1" => "처방약품",
    "2" => "대체약품"
);
reset($prescription_pill_type_array);

/**
 * 처방약국 타입
 **/
$prescription_pharmacy_status_array = array(
    "1" => "신청중",
    "2" => "조제가능",
    "3" => "대체조제",
    "4" => "조제불가",
    "5" => "결제완료"
);
reset($prescription_pill_type_array);


/**
 * 문의 상태 배열
 **/
$request_status_array = array(
    "1" => "신청",
    "2" => "보류",
    "3" => "확인완료"
);
reset($request_status_array);


/**
 * 오퍼 상태
 **/
$op_status_array = array(
    "1" => "대기",
    "2" => "활동",
    "3" => "정지",
    "4" => "퇴사"
);
reset($op_status_array);



/**
 * 오퍼 처방전 리스트 상태
 **/
$pre_status_array = array(
    ""  => "대기",
    "1" => "대기",
    "2" => "처리중",
    "3" => "완료",
    "4" => "중단",
    "5" => "판독불가"
);
reset($pre_status_array);


/**
 * 오퍼 처방전 리스트 상태
 **/
$pill_status_array = array(
    "1" => "판매중",
    "2" => "판매불가",
);
reset($pill_status_array);























############### 카테고리 관련 테이블  ####################
$E_TYPE_TB = "hm_edu_type_tb";            // 카테고리 대분류 테이블
$E_CONTENTS_TB = "hm_edu_contents_tb";        // 교육정보 테이블


############### 카테고리 관련 테이블  ####################
$L_TYPE_TB = "hm_large_type_tb";        // 카테고리 대분류 테이블
$M_TYPE_TB = "hm_middle_type_tb";        // 카테고리 소분류 테이블
//$S_TYPE_TB    = "hm_small_type_tb"  ;		// 카테고리 소분류 테이블


############### 컨셉 관련 테이블  ####################
$C_TYPE_TB = "hm_concept_type_tb";        // 카테고리 컨셉 테이블


############### 포트폴리오 관련 테이블  ####################
$PF_TB = "hm_portfolio_tb";        // 진료상태 테이블


############### 지역관련 테이블  ####################
$SIDO_TB = "hm_sido_type_tb";        // 시도 테이블
$GUGUN_TB = "hm_gugun_type_tb";        // 구군 테이블


############### 접수 관련 테이블  ####################
$F_TYPE_TB = "hm_faq_type_tb";        // FAQ 분류 테이블

$RQ_TB = "hm_request_tb";            // 접수 테이블
$QNA_TB = "hm_qna_tb";            // 문의 테이블
$FAQ_TB = "hm_faq_tb";            // FAQ 테이블
$RES_TB = "hm_reservation_tb";                // 상담예약 테이블
$C_RES_TB = "hm_chk_reservation_tb";        // 진료상태 테이블


############### 게시판 관련 테이블  ####################
$BD_CONFIG_TB = "hm_board_config_tb";        // 게시판 환경설정 테이블
$BD_TYPE_TB = "hm_board_type_tb";        // 게시판 분류코드 테이블


############### 로그 관련 테이블  ####################
$LOG_MEMBER_TB = "hm_log_member_tb";        // 회원로그인 로그 테이블
$LOG_POINT_TB = "hm_log_point_tb";        // 포인트 사용 로그 테이블
$LOG_PENALTY_TB = "hm_log_penalty_tb";        // 패널티 사용 로그 테이블


############### 팝업 테이블  ####################
$POPUP_TB = "hm_popup_tb";        // 에이젼시 테이블


############### 파트너 테이블  ####################
$PARTNER_TB = "hm_partner_tb";    // 파트너 테이블


############### 스튜디오 테이블  ####################
$STUDIO_TB = "hm_studio_tb";    // 스튜디오 테이블


############### 문의사항 테이블  ####################
$COUNSULT_TB = "hm_consult_tb";            // 문의사항 테이블


############### 견적서 테이블  ####################
$ESTIMATE_TB = "hm_estimate_tb";            // 문의사항 테이블

############### 찜 테이블  ####################
$ZZIM_TB = "hm_zzim_tb";            // 찜 테이블

############### 리뷰 테이블  ####################
$REVIEW_TB = "hm_review_tb";            // 찜 테이블

############### 분류 테이블  ####################
$KIND_TB = "hm_kind_tb";            // 찜 테이블


############### 교육 테이블  ####################
$EDU_CONTENTS_TB = "hm_edu_contents_tb";         //교육과정
$EDU_SCHEDULE_TB = "hm_edu_schedule_tb";         //교육일정


############### 교육 테이블  ####################
$EDU_APPLICATION_TB = "hm_edu_application_tb";    //교육신청
$EDU_CAREER_TB = "hm_edu_career_tb";         //경력 & 교육
$EDU_PAYMENT_TB = "hm_edu_payment_tb";        //결제


############### 대관 테이블  ####################
$RENT_ROOM_TB = "hm_rental_tb";               //대관실
$RENT_REQUEST_TB = "hm_rental_request_tb";       //대관신청
$RENT_TYPE_TB = "hm_rental_type_tb";          //선택사항


############### 시험 테이블  ####################
$EXAM_ITEM_TB = "hm_edu_exam_item_tb";        //시험문제 기본테이블
$EXAM_TB = "hm_edu_exam_tb";             //시험 기본테이블
$EXAM_RECODE_TB = "hm_edu_record_tb";           //시험 응시 테이블


############### 쿠폰 테이블  ####################
$COUPON_MAIN_TB = "hm_coupon_type_tb";        //쿠폰 테이블
$COUPON_REQ_TB = "hm_coupon_req_tb";         //쿠폰 항목 테이블
$COUPON_USER_TB = "hm_coupon_list_tb";        //쿠폰 유저 테이블


############### 설문 테이블  ####################
$EDU_SURVEY_TB = "hm_edu_survey_tb";        //교육설문 테이블
$EDU_SURVEY_RECORD_TB = "hm_edu_survey_record_tb";        //교육설문 테이블


############### 설문 테이블  ####################
$SURVEY_TB = "hm_survey_tb";               //설문 테이블
$SURVEY_ITEM_TB = "hm_survey_item_tb";          //설문 항목 테이블


############### 출석체크 테이블  ####################
$PRESENT_TB = "hm_edu_present_tb";            //출석체크 테이블


############### 수료증 테이블  ####################
$CERTIFICATE_TB = "hm_certificate_tb";            //수료증 테이블


############### 이미지 & 파일 위치 정보 ####################
$_SITE_IMG = "/images";

$RENTAL_URL = "../../_core/_files/rental/";    //대관 파일
$NOTICE_URL = "../../_core/_files/notice/";    //공지사항 파일
$POP_URL = "../../_core/_files/popup/";    //팝업 파일
$EDU_URL = "../../_core/_files/education/";    //교육과정 파일
$ALBUM_URL = "../../_core/_files/album/";    //KISEC ALBUM 파일
$LAB_URL = "../../_core/_files/lab/";    //KISEC LAB 파일
$COUPON_URL = "../../_core/_files/coupon/";    //쿠폰 파일

$D_URL = "../_core/_files/download";    //제품 메뉴얼 위치
$MEMBER_URL = "../../_core/_files/member/";    //전문가 회원 파일
$REVIEW_URL = "../_core/_files/review";    //이용후기 파일
$PORTFOLIO_URL = "../_core/_files/portfolio";    //포트폴리오 파일
$B_URL = "../../_core/_files/board/";    //게시판 파일
$W_URL = "../_core/_files/work/";    //폼메일 파일

$PARTNER_URL = "../_core/_files/partner/";    //파트너 파일
$T_URL = "../_core/_files/topic/";    //토픽 파일

$CSV_URL = "../_core/_files/csv/";    //CSV 파일


/**
 * 공통 정보 배열
 **/
// 요일
$week_array = array(
    "1" => "월",
    "2" => "화",
    "3" => "수",
    "4" => "목",
    "5" => "금",
    "6" => "토"
);
reset($week_array);

// 핸드폰 앞번호
$hp_array = array(
    "010",
    "011",
    "016",
    "017",
    "018",
    "019",
    "0130"
);
reset($hp_array);

// 일반번호 앞번호
$phone_array = array(
    "02",
    "031",
    "032",
    "033",
    "041",
    "042",
    "043",
    "051",
    "052",
    "053",
    "054",
    "055",
    "061",
    "062",
    "063",
    "064",
    "010",
    "011",
    "016",
    "017",
    "018",
    "019",
    "0130",
    "0502",
    "0503",
    "0505",
    "0506",
    "070",
    "080"
);
reset($phone_array);

// 메일주소 도메인
$email_array = array(
    "empal.com",
    "gmail.com",
    "hotmail.com",
    "korea.com",
    "nate.com",
    "naver.com"
);
reset($email_array);

// 직업분류
$job_array = array(
    "01" => "건설",
    "02" => "경영/경제",
    "03" => "과학/기술",
    "04" => "교육/컨설팅",
    "05" => "국방/방산",
    "06" => "금융",
    "07" => "기계/자동차",
    "08" => "법률/세무/회계",
    "09" => "서비스업",
    "10" => "섬유/의류/기타",
    "11" => "에너지/자원/환경",
    "12" => "유통/물류",
    "13" => "음식료품",
    "14" => "의약/바이오 의약/의료기기",
    "15" => "의학",
    "16" => "전자/정보통신/IT",
    "17" => "조선/해운",
    "18" => "출판/언론/방송",
    "19" => "화학",
    "20" => "기타"
);
reset($job_array);

// 업로드 금지 파일
$not_upload_array = array(
    "htm",
    "html",
    "phtml",
    "php",
    "php3",
    "php4",
    "inc",
    "pl",
    "cgi",
    "txt"
);
reset($not_upload_array);

// 지역 정보
$region_array = array(
    "01" => "서울",
    "02" => "부산",
    "03" => "대구",
    "04" => "인천",
    "05" => "광주",
    "06" => "대전",
    "07" => "울산",
    "08" => "경기",
    "09" => "강원",
    "10" => "충북",
    "11" => "충남",
    "12" => "세종",
    "13" => "전북",
    "14" => "전남",
    "15" => "경북",
    "16" => "경남",
    "17" => "제주",
    "18" => "기타(해외)"
);
reset($region_array);

// 특수문자 정보
$special_word = array('§', '※', '☆', '★', '○', '●', '◎', '◇', '▷', '▶', '♤', '♠', '♡', '♥', '♧', '♣', 'ㆀ', 'ε', '『', '』', 'ⓛ', '∏', 'ご', '♂', '◆', '□', '■', '△', '▲', '▽', '▼', '→', '⊙', '◈', '▣', '◐', '◑', '▒', '▦', '♨', '↗', '↙', '↖', '↘', 'Ψ', '＼', '∑', '†', '←', '↑', '↓', '↔', '〓', '◁', '♪', '◀', '☏', '☎', '☞', '☜', '♬', '㈜', '™', '℡', '㏘', '㏂', '㉿', 'づ', '￥', '‡', 'Ω', '▤');
reset($special_word);

// 공휴일
$holiday_array = array(
    "S0101" => "신정",
    "L1230" => " ",
    "L0101" => "설날",
    "L0102" => " ",
    "S0301" => "삼일절",
    "S0405" => "식목일",
    "S0505" => "어린이날",
    "L0408" => "석가탄신일",
    "S0606" => "현충일",
    "S0717" => "제헌절",
    "S0815" => "광복절",
    "L0814" => " ",
    "L0815" => "추석",
    "L0816" => " ",
    "S1003" => "개천절",
    "S1225" => "성탄절"
);
reset($holiday_array);

// 무통장 정보
$bank_array = array(
    "1" => array(
        "bankName" => "은행",
        "accountNumber" => "000-01-0000-000",
        "accountName" => "아무개"
    )
);
reset($bank_array);

// 은행
$bank_array = array(
    "1" => "국민",
    "2" => "기업",
    "3" => "농협",
    "4" => "신한(구 조흥포함) ",
    "5" => "외한",
    "6" => "우체국",
    "7" => "SC제일",
    "8" => "하나",
    "9" => "한국씨티(구 한미)",
    "10" => "우리",
    "11" => "경남",
    "12" => "광주",
    "13" => "대구",
    "14" => "도이치",
    "15" => "부산",
    "16" => "산업",
    "17" => "수협",
    "18" => "전북",
    "19" => "제주",
    "20" => "새마을금고",
    "21" => "신용협동조합",
    "22" => "상호저축은행중앙회"
);
reset($bank_array);


############### 게시판 스킨 ####################
$skin_array = array(
    "bbs_default" => "기본"
, "bbs_gallery" => "갤러리"
);

reset($skin_array);


$use_out_array = array(
    "o1" => "사이트 정보 부족",
    "o2" => "불친절 / 관리부족",
    "o3" => "시스템 에러 / 속도 불만",
    "o4" => "개인정보 유출 우려",
    "o5" => "더 이상 이용하지 않음",
    "o6" => "기타"
);
reset($use_out_array);


############### 약물 판매상태 ####################
$pill_status_array = array(
    "1" => "판매중",
    "2" => "판매금지"
);
reset($use_out_array);