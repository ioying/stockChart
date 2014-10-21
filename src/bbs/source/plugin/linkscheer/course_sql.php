INSERT INTO pre_links_course (cname, creadme,clogo)
VALUES ('英语900句', '曾经最受欢迎的、无数次尝试而未完成的', 'source/plugin/linkscheer/course/test/900c1.png')

INSERT INTO  `pre_links_lesson` ( cid, english, chinese, 
FILE , level, logo ) 
VALUES (
'1',  'Chance 英 [tʃɑ:ns] 美 [tʃæns]', 'n.机会，机遇； 概率，可能性； 偶然，运气<br/>v.偶然发生； 冒险； 碰巧； 偶然被发现<br/>adj.意外的； 偶然的； 碰巧的<br/>', 'source/plugin/linkscheer/course/test/chance.mp3',  '1',  ''
)



课程平均分 最高分 评分次数
SELECT a.qid,a.lessonid,a.uid,b.qid,avg(b.Score) as avgscore,max(b.Score) as maxscore ,count(*) as scorecount
FROM  `pre_linkscheer_question` a
LEFT JOIN  `pre_linkscheer_answer` b ON a.qid = b.qid 
WHERE a.uid = 1 and b.Score>0
group by a.qid 