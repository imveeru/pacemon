import cv2
from tracker import *
import numpy as np
end = 0

fileName ="nh_cam"
cap = cv2.VideoCapture("Resources/"+fileName+".mp4")
f = 25
w = int(1000/(f-1))

if cap.isOpened():
    video_width=cap.get(cv2.CAP_PROP_FRAME_WIDTH)
    video_height = cap.get(cv2.CAP_PROP_FRAME_HEIGHT)
    video_fps=cap.get(cv2.CAP_PROP_FPS)

print(f'Original Dimensions : {video_width} * {video_height} FPS: {video_fps} CamName: {fileName}')
half_width = int(video_width/2)
half_height = int(video_height/2)
print(f'Reduced Dimensions : {half_width} * {half_height}')

tracker = EuclideanDistTracker(half_height-(int(half_height/4)), int(half_height/9)*4, fileName)

print(f'Tracking Region : {half_height - (int(half_height / 4))} , {int(half_height / 9) * 4}')

object_detector = cv2.createBackgroundSubtractorMOG2(history=None,varThreshold=None)

kernalOp = np.ones((3,3),np.uint8)
kernalOp2 = np.ones((5,5),np.uint8)
kernalCl = np.ones((11,11),np.uint8)
fgbg=cv2.createBackgroundSubtractorMOG2(detectShadows=True)
kernal_e = np.ones((5,5),np.uint8)

while True:
    ret,frame = cap.read()
    frame = cv2.resize(frame, None, fx=0.5, fy=0.5)
    height,width,_ = frame.shape

    roi = frame[50:height,200:width]

    mask = object_detector.apply(roi)
    _, mask = cv2.threshold(mask, 250, 255, cv2.THRESH_BINARY)

    fgmask = fgbg.apply(roi)
    ret, imBin = cv2.threshold(fgmask, 200, 255, cv2.THRESH_BINARY)
    mask1 = cv2.morphologyEx(imBin, cv2.MORPH_OPEN, kernalOp)
    mask2 = cv2.morphologyEx(mask1, cv2.MORPH_CLOSE, kernalCl)
    e_img = cv2.erode(mask2, kernal_e)

    contours,_ = cv2.findContours(e_img,cv2.RETR_TREE,cv2.CHAIN_APPROX_SIMPLE)
    detections = []

    for cnt in contours:
        area = cv2.contourArea(cnt)
        if area > 1000:
            x,y,w,h = cv2.boundingRect(cnt)
            cv2.rectangle(roi,(x,y),(x+w,y+h),(0,255,0),3)
            detections.append([x,y,w,h])

    boxes_ids = tracker.update(detections)
    for box_id in boxes_ids:
        x,y,w,h,id = box_id


        if(tracker.getsp(id)<tracker.limit()):
            cv2.putText(roi,str(tracker.getsp(id))+" kmph",(x,y-15), cv2.FONT_HERSHEY_DUPLEX,1,(173,31,16),2)
            cv2.rectangle(roi, (x, y), (x + w, y + h), (0, 255, 0), 3)
        else:
            cv2.putText(roi,str(tracker.getsp(id))+" kmph",(x, y-15),cv2.FONT_HERSHEY_DUPLEX, 1,(0, 0, 255),2)
            cv2.rectangle(roi, (x, y), (x + w, y + h), (0, 0, 255), 3)

        s = tracker.getsp(id)
        if (tracker.f[id] == 1 and s != 0):
            tracker.capture(roi, x, y, h, w, s, id)

    cv2.imshow("PaceMon", roi)

    key = cv2.waitKey(w-5)

    if key==27:
        tracker.end()
        end=1
        break

if(end!=1):
    tracker.end()

cap.release()
cv2.destroyAllWindows()
