import pygame,sys
from time import sleep
from pygame import *
from pygame.mixer import *
from tkinter import *
from tkinter.messagebox import *
from tkinter.font import *

# 함수 선언

# 함수 정의
def rdoplay():
    path='music/bgmusic.mp3'
    mixer.init()
    mixer.music.load(path)          
    mixer.music.play(-1)
    
def Cplay(event):  
    global pet    
    pet=1
    mixer.init()
    bang=mixer.Sound("music/cat.wav")
    bang.play()
    sleep(1.1)
    clear()
    pagethree() #pagetwo→pagethree
    
def Dplay(event):
    global pet   
    pet=2
    mixer.init()
    bang=mixer.Sound("music/dog.wav")
    bang.play()
    sleep(0.5)
    clear()
    pagethree() #pagetwo→pagethree
    
def play():
    rdoplay()
    
def stop():
    mixer.music.stop()


def clear():
    list = w.pack_slaves()
    for i in list:
        i.destroy()
           
def pagemain():
    mname.pack()
    btn1.pack()
    btn2.pack()
    mainlogo.pack()
    name.pack()
    nameV.pack()
    money.pack()
    moneyV.pack()
    phone.pack()
    phoneV.pack()
    mainbtn.pack()
    
def pagetwo():
    mname=Label(w,text="♬Cha Cappella",font=Font(size=10))
    btn1 = Button(w, text='▶', command=play)
    btn2 = Button(w, text='■', command=stop)
    mname.pack()
    btn1.pack()
    btn2.pack()
    
    choice.pack()
    choiceC.pack(side="top")
    choiceD.pack(side="top")

def pagethree():
    mname=Label(w,text="♬Cha Cappella",font=Font(size=10))
    btn1 = Button(w, text='▶', command=play)
    btn2 = Button(w, text='■', command=stop)
    mname.pack()
    btn1.pack()
    btn2.pack()
    petinfo.pack()
    Breeds.pack(pady=7)
    if(pet==1):
        catinfo1.pack()
        catinfo2.pack()
        catinfo3.pack()
        catinfo1.select()
    elif(pet==2):
        doginfo1.pack()
        doginfo2.pack()
        doginfo3.pack()
        doginfo1.select()
    color0.pack(pady=7)
    color1.pack()
    color2.pack()
    color3.pack()
    color1.select()
    age.pack(pady=7)
    ageV.pack()
    threebtn.pack() 

def pagefour(v5,fee):
    clear()
    global v2
    v4=petcolor.get()-1
    
    v2-=fee
    fee=str(fee)
    v5=str(v5)
    if pet==1: 
        receipt=Label(w,font=Font(size=30),text="영수증")
        receipt1=Label(w,font=f,text="고객명: "+v1)
        receipt2=Label(w,font=f,text="애완동물 종류: 고양이")
        receipt3=Label(w,font=f,text="애완동물 나이: "+v5+"살")
        receipt4=Label(w,font=f,text="애완동물 색상: "+color[v4])
        receipt5=Label(w,font=f,text="애완동물 품종: "+C_Breeds[cat.get()-1])
        receipt6=Label(w,font=f,text="금액: "+fee)
        receipt7=Label(w,font=f,text="이용해주셔서 감사합니다!")
    elif pet==2:
        receipt=Label(w,font=Font(size=30),text="영수증")
        receipt1=Label(w,font=f,text="고객명: "+v1)
        receipt2=Label(w,font=f,text="애완동물 종류: 강아지")
        receipt3=Label(w,font=f,text="애완동물 나이: "+v5+"살")
        receipt4=Label(w,font=f,text="애완동물 색상: "+color[v4])
        receipt5=Label(w,font=f,text="애완동물 품종: "+D_Breeds[dog.get()-1])
        receipt6=Label(w,font=f,text="금액: "+fee)
        receipt7=Label(w,font=f,text="이용해주셔서 감사합니다!")
    
    receipt.pack()
    receipt1.pack()
    receipt2.pack()
    receipt3.pack()
    receipt4.pack()
    receipt5.pack()
    receipt6.pack()
    receipt7.pack()
    
def valueget1():
    global v1
    global v2
    global v3
    v1=nameV.get()
    v2=moneyV.get()
    v2=int(v2)
    v3=phoneV.get()
    if(nameV==""):
        showinfo('오류','이름을 입력하지 않으면 분양받으실 수 없습니다.')
        w.destroy()
    if(moneyV==""):
        showinfo('오류','소지금을 입력하지 않으면 분양받으실 수 없습니다.')
        w.destroy()
    if(phoneV==""):
        showinfo('오류','전화번호를 입력하지 않으면 분양받으실 수 없습니다.')
        w.destroy()

    clear()
    pagetwo() #pagemain→pagetwo
    
def valueget2():  #가격 계산
    global v2
    v5=int(ageV.get())
    fee=100000;
    if v5<9:
        fee-=v5*10000
    else:
        fee-=90000
    if v2<fee:
        showinfo('오류',v1+"님은 보유 금액 부족으로 애완동물을 분양 받으실 수 없습니다.")
        w.destroy()
    else:
        purchase=askokcancel("구매 확인","선택한 유형으로 분양받으시겠습니까?")
        if purchase==True:
            pagefour(v5,fee)  #pagethree→pagefour
    
# 윈도우w 생성
w = Tk()
w.geometry('1000x1000')
w.title('Pet Shop')
f=Font(family='1훈하얀고양이 R',size=22)

mname=Label(w,text="♬Cha Cappella",font=Font(size=10))
btn1 = Button(w, text='▶', command=play)
btn2 = Button(w, text='■', command=stop)

logo=PhotoImage(file='photo/logo.png')
mainlogo=Label(w,image=logo)

name=Label(w,font=f,text="성명:")
nameV=Entry(w,font=f)
nameV.insert(0,"홍길동")

money=Label(w,font=f,text="소지금:")
moneyV=Entry(w,font=f)
moneyV.insert(0,"1000000")

phone=Label(w,font=f,text="전화번호:")
phoneV=Entry(w,font=f)
phoneV.insert(0,"010-1234-5678")

mainbtn= Button(w, text='확인', font=f, command=valueget1)
threebtn= Button(w, text='확인', font=f, command=valueget2)

choice=Label(w,text="Choice Dog or Cat", font=Font(size=30))
cphoto=PhotoImage(file='photo/cat.png')
dphoto=PhotoImage(file='photo/dog.png')
choiceC=Label(w,image=cphoto)
choiceD=Label(w,image=dphoto)
choiceC.bind("<Button-1>",Cplay)
choiceD.bind("<Button-1>",Dplay)

petinfo=Label(w,font=Font(size=30),text="애완동물 유형을 선택해주세요")
C_Breeds=['노르웨이 숲','페르시안','러시안 블루']
D_Breeds=['골든 리트리버','시바견','말티즈']
color=['흰색','검은색','주황색']
cat=IntVar()
dog=IntVar()
petcolor=IntVar()
Breeds=Label(w,font=Font(size=25),text="품종:")
catinfo1=Radiobutton(w,text=C_Breeds[0],font=f,variable=cat, value=1)
catinfo2=Radiobutton(w,text=C_Breeds[1],font=f,variable=cat, value=2)
catinfo3=Radiobutton(w,text=C_Breeds[2],font=f,variable=cat, value=3)

doginfo1=Radiobutton(w,text=D_Breeds[0],font=f,variable=dog, value=1)
doginfo2=Radiobutton(w,text=D_Breeds[1],font=f,variable=dog, value=2)
doginfo3=Radiobutton(w,text=D_Breeds[2],font=f,variable=dog, value=3)

color0=Label(w,font=Font(size=25),text="색상:")
color1=Radiobutton(w,text=color[0],width=5,height=2,
                   bg='white',fg='black',font=f,variable=petcolor, value=1)
color2=Radiobutton(w,text=color[1],width=5,height=2,
                   bg='black',fg='#F88AB5',font=f,variable=petcolor, value=2)
color3=Radiobutton(w,text=color[2],width=5,height=2,
                   bg='orange',fg='black',font=f,variable=petcolor, value=3)

age=Label(w,font=f,text="애완동물의 나이:")
ageV=Entry(w,font=f)
ageV.insert(0,"2")

rdoplay()
pagemain()


